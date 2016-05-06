<?php

namespace Matks\MarkdownBlogBundle\Tests\Functional\Features\Context\Util;

use Behat\Gherkin\Node\TableNode;

class LineTableNodeReader
{
    /**
     * Convert a "column" TableNode into a LineTableNode
     *
     * Expected TableNode format:
     * | key 1 | line 1 value 1 | line 1 value 2 |
     * | key 2 | line 2 value 1 | line 2 value 2 |
     * | key 3 | line 3 value 1 | line 3 value 2 |
     *
     * @param TableNode $tableNode
     *
     * @return LineTableNode
     */
    public static function getLineTableNodeFromTableNodeInColumn(TableNode $tableNode)
    {
        $lineTableNode = new LineTableNode();

        foreach ($tableNode->getRows() as $row) {
            $key    = $row[0];
            $values = [];

            $isFirst = true;
            foreach ($row as $lineElement) {
                if ($isFirst) {
                    $isFirst = false;
                    continue;
                }

                $values[] = $lineElement;
            }
            $lineTableNode->addLine($key, $values);
        }

        return $lineTableNode;
    }

    /**
     * Convert a "line" TableNode into an array of LineTableNodes
     *
     * Expected TableNode format:
     * | key 1          | key 2          | key 3          |
     * | line 1 value 1 | line 1 value 2 | line 1 value 3 |
     * | line 2 value 1 | line 2 value 2 | line 2 value 3 |
     *
     * @param TableNode $tableNode
     *
     * @return LineTableNode[]
     */
    public static function getLineTableNodesFromTableNodeInline(TableNode $tableNode)
    {
        $lineTableNodes = [];

        $isFirstLine = true;
        $keys        = [];

        foreach ($tableNode->getRows() as $row) {
            if ($isFirstLine) {
                $keys = $row;

                $isFirstLine = false;
                continue;
            }

            $rowCount = count($row);
            if (count($keys) !== $rowCount) {
                throw new \Exception("Number of keys must be equal to number of elements in 'line' TableNode");
            }

            $lineTableNode = new LineTableNode();

            for ($i = 0; $i < $rowCount; $i++) {
                $lineTableNode->addLine($keys[$i], [$row[$i]]);
            }

            $lineTableNodes[] = $lineTableNode;
        }

        return $lineTableNodes;
    }
}
