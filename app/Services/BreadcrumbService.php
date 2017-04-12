<?php

namespace App\Services;

class BreadcrumbService
{

    private $row = [];

    /**
     * Add new breadcrumb
     *
     * @param string $label
     * @param null $link
     * @param bool $active
     * @return $this
     */
    public function add($label, $link = null, $active = false)
    {
        $this->row[] = (object)[
            'label' => $label,
            'link' => $link,
            'active' => $active,
        ];

        return $this;
    }

    /**
     * @return array
     */
    public function get()
    {
        $row = $this->row;
        $this->row = [];
        return $row;
    }

    public function getLast()
    {
        if (count($this->row) > 0) {
            return end($this->row);
        }
        return false;
    }

    public function push(array $data)
    {
        foreach ($data as $key => $value) {
            if ($key) {
                $this->add($key, $value);
            }
        }

        $last = $this->getLast();
        if ($last) {
            $label = $last->label;
            array_pop($this->row);
            $this->add($label, null, true);
        }

        return $this;
    }

}
