<?php

namespace SyntaxTree\Command;

class MaltParserCommand extends AbstractParseSyntaxCommand implements CommandInterface
{

    protected $maltParserPath;

    public function setPath($maltParserPath)
    {
        $this->maltParserPath = $maltParserPath;
        return $this;
    }

    public function execute()
    {
        $command = "./russian-malt.sh";

        $descriptors = [
            0 => ['pipe', 'r'], // stdin
            1 => ['pipe', 'w'], // stdout
            2 => ['pipe', 'w'], // stderr
        ];

        // ! Sure what ~/.cache/bazel is acceseble for www-data !
        $process = proc_open($command, $descriptors, $pipes, $this->maltParserPath);

        if (is_resource($process))
        {

            fwrite($pipes[0], $this->text);
            fclose($pipes[0]);

            $csv = stream_get_contents($pipes[1]);

            proc_close($process);
        }

        return $csv;
    }

}
