<?php


namespace Core\Repository;


use Core\Database\Database;

abstract class ARepository
{
//    abstract protected function getEntityClassName(): string;

    protected function getTableName(): string
    {
        $explode = explode("\\", $this->getEntityClassName());
        return $this->toSnakeCase($explode[count($explode) - 1]);
    }

    /**
     * @param string|null $limit
     * @return array
     */
    public function findAll(string $limit = null): array
    {
        $limit = ($limit) ? ' LIMIT ' . $limit : $limit;
        return Database::getInstance()->query(
            'SELECT * FROM ' . $this->getTableName() . $limit,
            [],
            $this->getEntityClassName()
        );
    }

    /**
     * @param int $id
     * @param array|null $selectedColumns
     * @return array|false|mixed
     */
    public function find(int $id, array $selectedColumns = null)
    {
        return Database::getInstance()->query(
            'SELECT '. $this->createSelectedColumnsInQuery($selectedColumns) .' FROM ' . $this->getTableName() . ' WHERE id=:id',
            ['id' => $id],
            $this->getEntityClassName(),
            true
        );
    }

    public function findBy(array $filters, string $orderBy = null): array
    {
        $orderBy = ($orderBy) ? ' ORDER BY ' . $orderBy : $orderBy;
        return Database::getInstance()->query(
            $this->createSelectQueryWithFilters($filters). $orderBy,
            $filters,
            $this->getEntityClassName()
        );
    }

    public function findOneBy(array $filters)
    {
        return Database::getInstance()->query(
            $this->createSelectQueryWithFilters($filters),
            $filters,
            $this->getEntityClassName(),
            true
        );
    }

    public function createSelectedColumnsInQuery(array $columns = null)
    {
        return (!$columns) ? '*' : implode(',', $columns);
    }

    /**
     * @param array $filters
     * @return string
     */
    private function createSelectQueryWithFilters(array $filters): string
    {
        return 'SELECT * FROM ' . $this->getTableName() . ' WHERE ' . join(
                ' AND ',
                array_map(
                    function ($key) {
                        return $this->toSnakeCase($key) . ' = :' . $key;
                    },
                    array_keys($filters)
                )
            );
    }

    public function add(array $datas)
    {
        unset($datas['id']);
        $addQueries = $this->createInsertQueryWithDatas($datas);
        Database::getInstance()->queryUpdate(
            'INSERT INTO ' . $this->getTableName() . $addQueries['columns'] .' VALUES ' . $addQueries['values'],
            $datas
        );
    }

    /**
     * @param array $filters
     * @return array
     */
    private function createInsertQueryWithDatas(array $datas): array
    {
        $queries['columns'] = ' ('. join(', ', array_keys($datas)) .') ';
        $queries['values'] = join(', ',
            array_map(
                function ($key) {
                    return ':' . $key;
                },
                array_keys($datas)
            )
        );
        $queries['values'] = ' ('. $queries['values'] .') ';
        return $queries;
    }

    public function edit(array $datas)
    {
        Database::getInstance()->queryUpdate(
            'UPDATE ' . $this->getTableName() . ' SET ' . $this->createUpdateQueryWithDatas($datas) . ' WHERE id = :id',
            $datas
        );
    }

    /**
     * @param array $filters
     * @return string
     */
    private function createUpdateQueryWithDatas(array $datas): string
    {
        return join(', ',
            array_map(
                function ($key) {
                    return "`" . $this->toSnakeCase($key) . "`" . ' = :' . $key;
                },
                array_keys($datas)
            )
        );
    }

    public function delete(string $id)
    {
        Database::getInstance()->queryUpdate(
            'DELETE FROM ' . $this->getTableName() . ' WHERE id = :id',
            ['id' => $id]
        );
    }

    public function deleteBySlug(string $slug)
    {
        Database::getInstance()->queryUpdate(
            'DELETE FROM ' . $this->getTableName() . ' WHERE slug = :slug',
            ['slug' => $slug]
        );
    }

    public function __call($name, $arguments)
    {
        if (str_starts_with($name, 'findBy')) {
            $columnName = str_replace('findBy', '', $name);

            return $this->findBy([$columnName => $arguments[0] ?? null]);
        }

        if (str_starts_with($name, 'findOneBy')) {
            $columnName = str_replace('findOneBy', '', $name);

            return $this->findOneBy([$columnName => $arguments[0] ?? null]);
        }

        throw new \Error('Call to undefined method ' . get_class($this) . '::' . $name);
    }

    private function toSnakeCase($text)
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $text));
    }
}