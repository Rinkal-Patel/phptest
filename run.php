<?php

require __DIR__ . './src/Network.php';
require __DIR__ . './src/Networkpath.php';
require __DIR__ . './src/Node.php';

//This occur when csv file path not included while run this program
if (empty($argv) || count($argv) < 2) {
    echo "Usage: php run.php [CSV FILE PATH] \n";
    exit;
}

//This occur when csv file not included
if (!file_exists($argv[1])) {
    echo "File not found \n";
    exit;
} else {
    try {
        $networkPath = new Networkpath($argv[1]);
        if ($networkPath) {
            while(true) {
                echo "##### Please enter a data (e.g - A F 1000 followed by ENTER key) ##### \n";
                $handle = fopen ("php://stdin","r");
                $line   = fgets($handle);
                if (strtoupper(trim($line)) == 'QUIT') {
                    echo "Program has been terminated!!! \n";
                    exit;
                } else {
                    if (($data = $networkPath->validateInputData($line))) {
                        $networkPath->setInitNodes();
                        $networkPath->findPath(
                            $networkPath->getNode(strtoupper($data[0])),
                            $networkPath->getNode(strtoupper($data[1]))
                        );
                        $networkPath->printPath(
                            $networkPath->getNode(strtoupper($data[0])),
                            $networkPath->getNode(strtoupper($data[1])),
                            intval($data[2])
                        );
                    } else {
                      //If enter invalid data
                        echo "invalid input data! \n\n";
                    }
                }
            }
        }
    } catch (Exception $e) {
        echo "- Exception: {$e->getMessage()} \n";
    }
    exit;
}
