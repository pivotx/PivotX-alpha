<?php

namespace PivotX\Component\Views;

// @todo should be abstract
class AbstractView implements ViewInterface
{
    protected $name = null;
    protected $group = null;
    protected $description = null;
    protected $long_description = null;
    protected $code_example = null;

    protected $arguments = array();
    protected $range_offset = null;
    protected $range_limit = null;

    /**
     * Set-up the arguments for the view
     *
     * @param array $arguments arguments to use
     */
    public function setArguments(array $arguments = null)
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * Set output result range
     *
     * @param integer $limit   limits the number of results
     * @param integer $offset  offset to start with
     * @return $this
     */
    public function setRange($limit = null, $offset = null)
    {
        $this->range_limit  = $limit;
        $this->range_offset = $offset;

        return $this;
    }

    /**
     * Set the output result range using pages
     *
     * @param integer $page   current page number (base 1)
     * @param integer $size   page size
     * @return $this
     */
    public function setCurrentPage($page, $size)
    {
        $this->range_offset = ($page - 1) * $size;
        $this->range_limit  = $size;
    }

    /**
     * Get results of the view
     *
     * @return mixed           the view result
     */
    // @todo should be abstract
    public function getResult()
    {
        return array();
    }

    /**
     * Return the total number of results
     *
     * @return integer return the total number of results for the result-set
     */
    // @todo should be abstract
    public function getLength()
    {
        return 0;
    }

    /**
     * Return query arguments
     *
      @return array the query arguments
     */
    // @todo should be abstract
    public function getQueryArguments()
    {
        return array();
    }

    /**
     * Get the current page number
     *
     * @return integer current page number (base 1), or 0 if cannot be determined
     */
    public function getCurrentPage()
    {
        if (is_null($this->range_limit) || is_null($this->range_offset)) {
            return 0;
        }
        if ($this->range_limit < 1) {
            return 0;
        }
        return floor($this->range_offset / $this->range_limit) + 1;
    }

    /**
     * Return the total number of pages of results
     *
     * @return integer return the total number of pages of results for the result-set
     */
    public function getNoOfPages()
    {
        if (is_null($this->range_limit)) {
            return 0;
        }

        return ceil($this->getLength() / $this->range_limit);
    }


    /**
     * Get the name of the view
     *
     * @return string view name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the group of the view
     *
     * @return string group name
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Get a developer description of the view
     *
     * @return string view description (falls back to name)
     */
    public function getDescription()
    {
        if (!is_null($this->description)) {
            return $this->description;
        }
        return 'No description for "'.$this->name.'"';
    }

    /**
     * Get the long developer description of the view
     *
     * @return string view long description
     */
    public function getLongDescription()
    {
        if (!is_null($this->long_description)) {
            return $this->long_description;
        }
        return false;
    }

    /**
     */
    public function getCodeExample()
    {
        if (!is_null($this->code_example)) {
            return $this->code_example;
        }

        $name       = $this->getName();
        $resultname = 'items';
        $loopvar    = 'item';

        return <<<THEEND
<pre class="prettyprint linenums lang-html">
{% loadView '$name' as $resultname %}
&lt;ul&gt;
{% for $loopvar in $resultname %}
    &lt;li&gt;
        {{ $loopvar.title }}
    &lt;/li&gt;
{% endfor %}
&lt;/ul&gt;
</pre>
THEEND;
    }
}
