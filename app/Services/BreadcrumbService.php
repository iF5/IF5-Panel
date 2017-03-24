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

}
