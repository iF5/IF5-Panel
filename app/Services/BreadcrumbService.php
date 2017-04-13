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
     * Push all breadcrumbs
     *
     * @param array $data
     * @return $this
     */
    public function push(array $data)
    {
        foreach ($data as $key => $value) {
            if ($key) {
                $this->add($key, $value);
            }
        }

        $last = $this->getLast();
        if ($last) {
            array_pop($this->row);
            $this->add($last->label, null, true);
        }
        return $this;
    }

    /**
     * @return object
     */
    public function get()
    {
        $row = $this->row;
        $this->row = [];
        return $row;
    }

    /**
     * @return bool|mixed
     */
    public function getLast()
    {
        if (count($this->row) > 0) {
            return end($this->row);
        }
        return false;
    }

}
