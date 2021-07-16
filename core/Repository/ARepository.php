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

    public function findAll(): array
    {
        return Database::getInstance()->query(
            'SELECT * FROM ' . $this->getTableName(),
            [],
            $this->getEntityClassName()
        );
    }

    public function find(int $id)
    {
        return Database::getInstance()->query(
            'SELECT * FROM ' . $this->getTableName() . ' WHERE id=:id',
            ['id' => $id],
            $this->getEntityClassName(),
            true
        );
    }

    public function findBy(array $filters): array
    {
        return Database::getInstance()->query(
            $this->createSelectQueryWithFilters($filters),
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

    public function add(string $slug, array $datas)
    {
        $allDatas = $datas;
        $allDatas['slug'] = $slug;
        $addQueries = $this->createInsertQueryWithDatas($allDatas);
        var_dump('INSERT INTO ' . $this->getTableName() . $addQueries['columns'] .' VALUES ' . $addQueries['values']);
        Database::getInstance()->queryUpdate(
            'INSERT INTO ' . $this->getTableName() . $addQueries['columns'] .' VALUES ' . $addQueries['values'],
            $allDatas
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

    public function edit(string $slug, array $datas)
    {
        $allDatas = $datas;
        $allDatas['slug'] = $slug;
        Database::getInstance()->queryUpdate(
            'UPDATE ' . $this->getTableName() . ' SET ' . $this->createUpdateQueryWithDatas($datas) . ' WHERE slug=:slug',
            $allDatas
        );
    }

    public function delete(string $slug)
    {
        Database::getInstance()->queryUpdate(
            'DELETE FROM ' . $this->getTableName() . ' WHERE slug = :slug'
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