<?php

namespace PivotX\Component\Views;


/**
 */
interface ViewInterface
{
    /**
     * Set-up the arguments for the view
     *
     * @param array $arguments arguments to use
     */
    public function setArguments(array $arguments = null);

    /**
     * Set output result range
     *
     * @param integer $limit   limits the number of results
     * @param integer $offset  offset to start with
     * @param array $arguments arguments to use
     */
    public function setRange($limit = null, $offset = null);

    /**
     * Get results of the view
     *
     * @return mixed           the view result
     */
    public function getResults();

    /**
     * Return the total number of results
     *
     * @return integer return the total number of results for the result-set
     */
    public function countTotalResults();

    /**
     * Get the name of the view
     *
     * @return string view name
     */
    public function getName();

    /**
     * Get the group of the view
     *
     * @return string group name
     */
    public function getGroup();
}
