<?php
namespace Core\HTML;

/**
 * Class BootstrapForm
 * @package Core\HTML
 */
class BootstrapForm extends Form
{
    /**
     * Return string
     */
    protected function surround($html)
    {
        return "<div class=\"form-group\">{$html}</div>";
    }

    /**
     * @param $name string
     * @param $label string
     * @param $option array
     * Return string
     */
    public function input($name, $label, $options = [])
    {
        $type        = isset($options['type']) ? $options['type'] : 'text';
        $placeholder = isset($options['placeholder']) ? $options['placeholder'] : '';

        if ($label != '') {
            $label = '<label>' . $label . '</label>';
        }
        if ($type === 'textarea') {
            $input = '<textarea name="' . $name . '" class="form-control" placeholder="' . $placeholder . '">' . $this->getValue($name) . '</textarea>';
        } else {
            $input = '<input type="' . $type . '" name="' . $name . '" value="' . $this->getValue($name) . '" class="form-control" placeholder="' . $placeholder . '">';
        }

        return $this->surround($label . $input);
    }

    public function select($name, $label, $options)
    {
        if ($label != '') {
            $label = '<label>' . $label . '</label>';
        }
        $input = '<select class="form-control" name="' . $name . '" id="' . $name . '">';
        foreach ($options as $k => $v) {
            $attributes = '';
            if ($k == $this->getValue($name)) {
                $attributes = ' selected';
            }
            $input .= '<option value="' . $k . '" ' . $attributes . '>' . $v . '</option>';
        }
        $input .= '</select>';

        return $this->surround($label . $input);
    }

    /**
     * Return string
     */
    public function submit()
    {
        return $this->surround('<button type="submit" class="btn btn-primary">Envoyer</button>');
    }
}
