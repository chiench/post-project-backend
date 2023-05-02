<?php

namespace App\Repositories\TraitRepository;

trait QueryBuilderTrait
{
    public $query;
    public $DATA_QUERY = [];
    /**
     * Summary of builderQueryTo
     * @param mixed $request
     * @return self
     */
    public function builderQueryTo($request = null): self
    {
        $this->query = $this->class::query();
        $this->DATA_QUERY = $request->all();
        return $this;
    }

}