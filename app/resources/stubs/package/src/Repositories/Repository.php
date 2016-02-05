<?php namespace Ccblearning\Courses\Repositories;

use Illuminate\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Sebwite\Database\Repositories\AbstractRepository;

class Repository extends AbstractRepository implements RepositoryInterface
{
    protected $namespace = 'ccblearning.courses.course';

    /**
     * The Eloquent modules model.
     *
     * @var string
     */
    protected $model;

    /**
     * Constructor.
     *
     * @param  \Illuminate\Container\Container           $app
     * @param \Illuminate\Contracts\Events\Dispatcher    $events
     * @param \Illuminate\Contracts\Validation\Validator $validator
     */
    public function __construct(Container $app, Dispatcher $events, ValidatorInterface $validator)
    {
        $this->setContainer($app);
        $this->setDispatcher($events);
        $this->setValidator($validator);
        $this->setModel(get_class($app[ 'Ccblearning\Courses\Models\Course' ]));
    }

    /**
     * {@inheritDoc}
     */
    public function store($id, array $input)
    {
        return ! $id ? $this->create($input) : $this->update($id, $input);
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $input)
    {
        $course = $this->createModel();
        if ($this->fireEvent($this->namespace . '.creating', [ $input ]) === false) {
            return false;
        }

        $messages = $this->validForCreation($input);
        if ($messages->isEmpty()) {
            $course->fill($input)->save();
            $this->fireEvent($this->namespace . '.created', [ $course ]);
        }

        return [ $messages, $course ];
    }

    /**
     * {@inheritDoc}
     */
    public function update($id, array $input)
    {
        $course = $this->find($id);
        if ($this->fireEvent($this->namespace . '.updating', [ $course, $input ]) === false) {
            return false;
        }

        $messages = $this->validForUpdate($course->id, $input);

        if ($messages->isEmpty()) {
            $course->fill($input);
            $course->save();
            $this->fireEvent($this->namespace . '.updated', [ $course ]);
        }

        return [ $messages, $course ];
    }
}
