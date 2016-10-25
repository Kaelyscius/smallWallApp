<?php
namespace Core\HTML;

/**
 * Class Form
 * @package Core\HTML
 */
class Form
{
    private $data;
    public $surround = 'p';

    public function __construct($data = array())
    {
        $this->data = $data;
    }

    protected function surround($html)
    {
        return "<{$this->surround}>{$html}</{$this->surround}>";
    }

    protected function getValue($index)
    {
        if (is_object($this->data)) {
            return $this->data->$index;
        }
        return isset($this->data[$index]) ? $this->data[$index] : null;
    }

    /**
     * @param $name
     * @param $label
     * @param array $options
     * @return string
     */
    public function input($name, $label, $options = [])
    {
        $type = isset($options['type']) ? $options['type'] : 'text';
        return $this->surround(
            '<input type="' . $type . '" name="' . $name . '" value="' . $this->getValue($name) . '">'
        );
    }

    /**
     * @param $name
     * @param array $options
     * @param $multiple Boolean
     * @return string
     */
    public function checkbox($name, $options, $multiple = false)
    {
        if ($multiple) {
            $name = $name.'[]';
        }
        $input = '';
        $i = 0;
        foreach ($options as $k => $v) {
            $i++;
            $input .=  '<label><input type="checkbox" name="'.$name.'"" id="checkbox'.$i.'" value="'.$k.'"> '.$v.'</label><br>';         
        }
        return $this->surround($input);
    }

    public function submit()
    {
        return $this->surround('<button type="submit">Envoyer</button>');
    }
}
