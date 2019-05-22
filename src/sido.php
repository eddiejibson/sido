<?php
namespace eddiejibson;

class Sido
{
    public function __construct(array $options = [])
    {
        $this->discord = false;
        if (isset($options) && is_array($options)) {
            if (isset($options["discord"]) && is_array($options["discord"])) {
                $this->discord = [
                    "webhook" => $options["discord"]["webhook"] ?? false,
                    "username" => $options["discord"]["username"] ?? false
                ];
            }
        }
        echo "Starting tests...\n";
        $this->startingTime = microtime(true);
        $this->totalTime = 0;
        $this->sinceLast = microtime(true);
        $this->tests = [];
        $this->failed = [];
        $this->success = 0;
        $this->case = "default";
        $this->caseCount = [];
        $this->concluded = false;
    }

    private function getTimestamp()
    {
        $dt = new DateTime();
        return $dt->format(DateTime::ATOM);
    }

    public function setCase(string $label = "default")
    {
        echo "\n" . $label . " :\n\n";
        $this->case = $label;
        if (!isset($this->tests[$label]) || !is_array($this->tests[$label])) {
            $this->tests[$label] = [];
        }
    }

    public function should($statement, string $desc = "evaluate to true")
    {
        $res = false;
        $arr = [
            "desc" => $desc,
            "error" => false
        ];
        if (!isset($this->caseCount[$this->case])) {
            $this->caseCount[$this->case] = ["count" => 1, "timestamp" => $this->getTimestamp()];
        } else {
            $this->caseCount[$this->case]["count"]++;
        }
        if (isset($statement) && (bool)$statement == true) {
            $arr["duration"] = (microtime(true) - $this->sinceLast) / 1000;
            $res = true;
            echo str_pad("\033[32m ✓ " . $desc . ". Success. Statement evaluated to be true. \033[0m(" . (string)(microtime(true) - $this->sinceLast) . " ms)\n", 30, " ", STR_PAD_LEFT);
            $this->success++;
        } else {
            $arr["duration"] = (microtime(true) - $this->sinceLast) / 1000;
            echo str_pad("\033[31m ❌ " . $desc . ". Failed. Statement evaluated to be false. \033[0m(" . (string)(microtime(true) - $this->sinceLast) . " ms)\n", 30, " ", STR_PAD_LEFT);
            $arr["error"] = "Should " . $desc . " Failed. Statement evaluated to be false";
            $res = false;
            array_push($this->failed, ["case" => $this->case]);
        }
        array_push($this->tests[$this->case], $arr);
        $this->sinceLast = microtime(true);
    }

    private function submitReq(string $url, array $arr)
    {
        $json = json_encode($arr);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($json)
            )
        );
        return curl_exec($ch);
    }


    public function conclude()
    {
        $this->totalTime = microtime(true) - $this->startingTime;
        $this->generateReport();
        echo "\n\nTests completed in a total of " . (string)($this->totalTime) . " ms.\n";
        $failedCount = count($this->failed);
        $totalTests = (string)($this->success + $failedCount);
        echo "There were $totalTests  total tests. Of them, there were:\n\n";
        echo "\033[32m" . $this->success . " successful test(s).\n\n";
        echo "\033[31m" . (string)($failedCount) . " failed test(s).\n\n\n";
        $title = "Tests Passed!";
        $color = 3066993;
        if ($failedCount >= 1) {
            $title = "Tests Failed :(";
            $color = 15158332;
            echo "❌ Tests failed.\033[0m\n";
        } else {
            echo "\033[32m ✓ Tests passed!\033[0m\n";
        }
        $this->concluded = true;
        if (isset($this->discord) && isset($this->discord["webhook"])) {
            $this->submitReq($this->discord["webhook"], ["username" => ($this->discord["username"] ?? "Sido Test Runner"), "embeds" => [["color" => $color, "title" => $title, "footer" => ["text" => "Tests ran by Sido."], "description" => "\n\nTests completed in a total of " . (string)(number_format($this->totalTime, 5)) . " ms.\n\nThere were $totalTests total tests. Of them, there were:\n\n🚫 **Failed Tests**: $failedCount\n\n✅ **Passed Tests**: $this->success\n"]]]);
        }
    }

    private function generateReport($xml = false)
    {
        $failedCount = count($this->failed);
        if ($xml === false) {
            $time = (string)(number_format($this->totalTime / 1000, 10));
            $tests = (string)($this->success + $failedCount);
            $failures = (string)$failedCount;
            $xml = new SimpleXMLElement("<testsuites time='$time' tests='$tests' failures='$failures' name='Sido Tests'/>");
        }
        if (count($this->tests) > 0) {
            foreach ($this->tests as $testsuite => $val) {
                $test = $xml->addChild("testsuite");
                $test->addAttribute("name", $testsuite);
                $test->addAttribute("tests", count($val));
                $test->addAttribute("file", realpath(__FILE__));
                $test->addAttribute("timestamp", $this->caseCount[$testsuite]["timestamp"]);
                // var_dump($val);
                $failures = 0;
                foreach ($val as $testcase => $value) {

                    $case = $test->addChild("testcase");
                    $case->addAttribute("name", "$testsuite Should " . $value["desc"]);
                    $case->addAttribute("classname", "Should " . $value["desc"]);
                    $case->addAttribute("time", number_format($value["duration"], 8));
                    if ($value["error"] && is_string($value["error"])) {
                        $failures++;
                        $failChild = $case->addChild("failure", $value["error"]);
                        $failChild->addAttribute("message", $value["error"]);
                        $failChild->addAttribute("type", "AssertionError");
                    }
                }
                $test->addAttribute("failures", $failures);
            }
        }

        $xml->asXML("report.xml");
    }
    public function __destruct()
    {
        if (!$this->concluded) {
            $this->conclude();
        }
    }
}
