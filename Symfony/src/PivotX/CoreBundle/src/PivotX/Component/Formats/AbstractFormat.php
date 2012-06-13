<?php

namespace PivotX\Component\Formats;


/**
 */
// @todo should be abstract
class AbstractFormat implements FormatInterface
{
    protected $name = null;
    protected $group = null;
    protected $description = null;

    public function __construct($name, $group = 'Ungrouped', $description = null)
    {
        $this->name        = $name;
        $this->group       = $group;
        $this->description = $description;
    }

    /**
     * Perform the actual format
     *
     * @param array $arguments arguments for formatting
     * @return mixed           format result
     */
    public function format($in, $arguments = array())
    {
        return $in;
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
     * @return string view description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get a code example
     *
     * @return string a code example
     */
    public function getCodeExample()
    {
        $name = $this->name;

        return <<<THEEND
<pre class="prettyprint linenums lang-html">
{{ page.title|formatas('$name') }}
</pre>
THEEND;
    }
}
