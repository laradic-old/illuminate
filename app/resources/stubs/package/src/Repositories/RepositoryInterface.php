<?php namespace Ccblearning\Courses\Repositories;

interface RepositoryInterface extends RepositoryInterface
{
    /**
     * Creates or updates the given courses.
     *
     * @param  int   $id
     * @param  array $input
     * @return bool|array
     */
    public function store($id, array $input);

    /**
     * Creates a courses entry with the given data.
     *
     * @param  array $data
     * @return \Ccblearning\Courses\Models\Course
     */
    public function create(array $data);

    /**
     * Updates the courses entry with the given data.
     *
     * @param  int   $id
     * @param  array $data
     * @return \Ccblearning\Courses\Models\Course
     */
    public function update($id, array $data);
}
