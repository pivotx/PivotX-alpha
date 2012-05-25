<?php

namespace PivotX\Component\Views;


/**
 */
interface ViewInterface
{
    /**
     * Execute the view
     *
     * @param array $arguments arguments to use
     * @return mixed           the view result
     */
    public function run($arguments = array());

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
