<?php

namespace App\Repositories;

use App\Contracts\BookRepositoryInterface;
use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookRepository implements BookRepositoryInterface
{
    protected $model;

    public function __construct(Book $model)
    {
        $this->model = $model;
    }

    public function findAll(): Collection
    {
        return $this->model->all();
    }

    public function get(int $id)
    {
        $book =  $this->model->findOrFail($id);

        return $book;
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, int $id)
    {
        $record = $this->get($id);

        if (!$record) throw new ModelNotFoundException();

        return $record->update($data);
    }

    public function delete($id)
    {
        $record = $this->get($id);
       
        if (!$record) throw new ModelNotFoundException();

        return $record->delete();
    }
}
