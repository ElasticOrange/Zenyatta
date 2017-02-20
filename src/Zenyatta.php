<?php

namespace ElasticOrange\Zenyatta;

use \Everyman\Neo4j\Client;

class Zenyatta
{
    // Save the singleton instance here
    // private static $_instance = null;

    // Save the client connection
    private $client = null;

    /**
     * Initialize the class with all things needed
     *
     * @param Zenyatta
     */
    public function __construct($config = null)
    {
        if (!$config)
        {
            $config = config('zenyatta');
        }
        return $this->createConnection($config);
    }

    // /**
    //  * @param array $config
    //  *
    //  * @return Zenyatta
    //  */
    // private function getInstance($config = array())
    // {
    // 	if (!$config)
    // 	{
    // 		$config = config('zenyatta');
    // 	}
    //
    // 	/**
    // 	 * Init the library and setup the connection
    // 	 */
    // 	if (!isset(self::$_instance))
    // 	{
    // 		self::$_instance = $this->createConnection($config);
    // 	}
    //
    // 	return self::$_instance;
    // }

    /**
     * Create the connection to the provided server
     *
     * @param  array $config contains the necessary data from the config file to create the connection
     *
     * @return Zenyatta
     */
    private function createConnection($config)
    {
        // Setup connection
        $this->client = new \Everyman\Neo4j\Client($config['server'], $config['port']);
        if ($config['authenticate']) {
            $this->client->getTransport()->setAuth($config['user'], $config['password']);
        }

        return $this;
    }

    /**
     * Get an array of label names from label objects.
     *
     * @param array $labels
     */
    private function getLabelNames($labels)
    {
        $lbls = array();
        foreach ($labels as $lbl) {
            $lbls[] = $lbl->getName();
        }

        return $lbls;
    }

    /**
     * Produces an array to output the given node by JSON.
     *
     * @param \Everyman\Neo4j\Node $node
     */
    private function outputNode($node)
    {
        $nodeLabels = $this->getLabelNames($node->getLabels());
        $out = array(
            'id' => $node->getId(),
            'labels' => $nodeLabels,
            'properties' => $node->getProperties(),
        );

        return $out;
    }

    /**
     * Produces an array to output the given relationship by JSON.
     *
     * @param Everyman\Neo4j\Relationship $rel
     */
    private function outputRelationship($rel)
    {
        $from = $rel->getStartNode()->getId();
        $to = $rel->getEndNode()->getId();
        $reltype = $rel->getType();

        $out = array(
            'id' => $rel->getId(),
            'type' => $reltype,
            'source' => $from,
            'target' => $to,
            'properties' => $rel->getProperties(),
        );

        return $out;
    }

    /**
     * Builds a row of output from a row of a resultset.
     *
     * @param \Everyman\Neo4j\Query\Row $row
     *
     * @return \Row
     */
    private function buildOutputRow($row)
    {
        $outputRow = array();
        foreach ($row as $key => $value) {
            $item = $row[$key];

            // Handle nodes
            if ($item instanceof \Everyman\Neo4j\Node) {
                // Format node for output
                $outputRow[$key] = self::outputNode($item);
            } elseif ($item instanceof \Everyman\Neo4j\Relationship) {
                // Format relationship for output
                $outputRow[$key] = outputRelationship($item);
            } elseif ($item instanceof \Everyman\Neo4j\Query\Row) {
                // Item is a nested row (custom object)
                $outputRow[$key] = self::buildOutputRow($item);
            } else {
                // Hope for the best
                $outputRow[$key] = $item;
            }
        }

        return $outputRow;
    }

    /**
     * Builds a table of output (nodes and relationships will be filled out).
     *
     * @param \Everyman\Neo4j\Query\ResultSet $resultset
     */
    private function buildOutputTable($resultset)
    {
        $out = array();
        foreach ($resultset as $row) {
            $outputRow = self::buildOutputRow($row);
            $out[] = $outputRow;
        }

        return $out;
    }

    /**
     * Run a query and return the response
     *
     * @param  string $queryString 		the Cypher query
     * @param  array $parameters  		contains the parameters
     *
     * @return [type]              [description]
     */
    public function getQuery($queryString, $parameters = [])
    {
        $queryCypher = new \Everyman\Neo4j\Cypher\Query(
            $this->client,
            $queryString,
            $parameters
        );

        $result = $queryCypher->getResultSet();

        return $this->buildOutputTable($result);
    }

    public function createNode($labels = [], $properties = [])
    {
        $node = $this->client->makeNode();
        $node->save();

        // Add labels
        $createdLabels = [];
        foreach ($labels as $l) {
            $createdLabels []= $this->client->makeLabel($l);
        }
        if (count($createdLabels)) {
            $node->addLabels($createdLabels);
        }

        // Add properties
        foreach ($properties as $name => $value) {
            $node->setProperty($name, $value);
        }

        $node->save();

        return $node->getId();
    }

    public function deleteNode($nodeId)
    {
        $node = $this->client->getNode($nodeId);

        $node->delete();
    }
}
