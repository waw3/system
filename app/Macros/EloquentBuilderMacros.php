<?php
return [

    /**
     * addSubSelect function.
     *
     * @access public
     * @param mixed $column
     * @param mixed $query
     * @return Builder
     */
    'addSubSelect' => function ($column, $query) {
        $this->defaultSelectAll();
        return $this->selectSub($query->limit(1)->getQuery(), $column);
    },

    /**
     * defaultSelectAll function.
     *
     * @access public
     * @return Builder
     */
    'defaultSelectAll' => function () {
        if (is_null($this->getQuery()->columns)) {
            $this->select($this->getQuery()->from.'.*');
        }
        return $this;
    },

    /**
     * joinRelation function.
     *
     * @access public
     * @param string $relationName
     * @param string $operator (default: '=')
     * @return Builder
     */
    'joinRelation' => function (string $relationName, $operator = '=') {
        $relation = $this->getRelation($relationName);
        return $this->join(
            $relation->getRelated()->getTable(),
            $relation->getQualifiedForeignKeyName(),
            $operator,
            $relation->getQualifiedOwnerKeyName()
        );
    },

    /**
     * joinRelation function.
     *
     * @access public
     * @param string $relationName
     * @param string $operator (default: '=')
     * @return Builder
     */
    'leftJoinRelation' => function (string $relationName, $operator = '=') {
        $relation = $this->getRelation($relationName);
        return $this->leftJoin(
            $relation->getRelated()->getTable(),
            $relation->getQualifiedForeignKeyName(),
            $operator,
            $relation->getQualifiedOwnerKeyName()
        );
    },

    /**
     * map function.
     *
     * @access public
     * @param callable $callback
     * @return Builder
     */
    'map' => function (callable $callback) {
        return $this->get()->map($callback);
    },

    /**
     * whereLike function.
     *
     * @access public
     * @param mixed $columns
     * @param string $value
     * @return Builder
     */
    'whereLike' => function ($columns, string $value) {
        $this->where(function (Builder $query) use ($columns, $value) {
            foreach (array_wrap($columns) as $column) {
                $query->when(
                    str_contains($column, '.'),
                    // Relational searches
                    function (Builder $query) use ($column, $value) {
                        [$relationName, $relationColumn] = explode('.', $column);
                        return $query->orWhereHas(
                            $relationName,
                            function (Builder $query) use ($relationColumn, $value) {
                                $query->where($relationColumn, 'LIKE', "%{$value}%");
                            }
                        );
                    },
                    // Default searches
                    function (Builder $query) use ($column, $value) {
                        return $query->orWhere($column, 'LIKE', "%{$value}%");
                    }
                );
            }
        });
        return $this;
    },

    /**
     * Search through one or multiple columns in table.
     *
     * @access public
     * @param mixed $attributes
     * @param mixed $needle
     * @return Builder
     */
    'searchIn' => function ($attributes, $needle) {
        if (is_null($needle)) {
            return $this;
        }
        return $this->where(function (Builder $query) use ($attributes,$needle) {
            foreach (\Illuminate\Support\Arr::wrap($attributes) as $attribute) {
                $query->orWhere($attribute, 'LIKE', "%{$needle}%");
            }
        });
    },

    /**
     * Orders sub-query results.
     *
     * @access public
     * @param mixed $query
     * @param string $direction (default: 'asc')
     * @return Builder
     */
    'orderBySub' => function ($query, $direction = 'asc') {
        return $this->orderByRaw("({$query->limit(1)->toSql()}) {$direction}");
    },

    /**
     * ders sub-query results in descending order.
     *
     * @access public
     * @param mixed $query
     * @return Builder
     */
    'orderBySubDesc' => function ($query) {
        return $this->orderBySub($query, 'desc');
    },


    /*
     * Check passed condition, and adds
     * custom `where` clause to query on true
     * Originally posted on https://themsaid.com/laravel-query-conditions-20160425
     * Model::if($request->user_id, 'user_id', '=', $request->user_id)->get()
     *
     * @param string $column
     * @param        $param
     *
     * @return Builder
     */
    'if' => function ($condition, $column, $operator, $value) {
        if ($condition) {
            return $this->where($column, $operator, $value);
        }
        return $this;
    },

    /**
     * Check is specified param is empty, if not, adds `whereIn` condition to exiting query
     * Model::notEmptyWhereIn('column',$request->input('user_ids'))->get()
     * @access public
     * @param mixed $column
     * @param mixed $params
     * @return Builder
     */
    'notEmptyWhereIn' => function ($column, $params) {
        $this->when(!empty($params), function (Builder $query) use ($column, $params) {
            return $query->whereIn($column, Arr::wrap($params));
        });
        return $this;
    },

    /**
     * Check is specified param is empty, if not, adds `where` condition to exiting query
     * Model::notEmptyWhere('column',$request->input('key'))->get();
     * @access public
     * @param mixed $column
     * @param mixed $param
     * @return Builder
     */
    'notEmptyWhere' => function ($column, $param) {
        $this->when(!empty($param), function (Builder $query) use ($column, $param) {
            return $query->where($column, $param);
        });
        return $this;
    },



];
