<?php

namespace App\Traits;

use App\Enums\RelationTypes;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

trait HasRelation
{
    /**
     * @throws Exception
     */
    public function safelySaveRelations(array $attributes): void
    {
        DB::beginTransaction();

        try {
            $this->saveRelations($attributes);
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        DB::commit();
    }

    public function saveRelations(array $attributes): void
    {
        $relations = $this->getFillableRelations();
        foreach (Arr::only($attributes, array_keys($relations)) as $relation => $value) {
            switch ($relations[$relation]) {
                case RelationTypes::OneToOne:
                    $this->saveRelation($relation, $value);
                    break;
                case RelationTypes::OneToMany:
                    foreach ($value as $item) {
                        $this->saveRelation($relation, $item);
                    }
                    break;
                case RelationTypes::ManyToMany:
                    $this->model->{$relation}()->sync($value);
                    break;
            }
        }
    }

    public function saveRelation(string $relation, array $attributes): Model
    {
        return !empty($attributes['id'])
            ? $this->updateRelation($relation, $attributes)
            : $this->createRelation($relation, $attributes);
    }

    public function updateRelation(string $relation, array $attributes): Model|null
    {
        $model = $this->{$relation}()->find($attributes['id']);
        if (empty($model)) {
            return null;
        }
        $model->fillAndSave($attributes);
        return $model;
    }

    public function createRelation(string $relation, array $attributes): Model
    {
        $relation = $this->{$relation}();
        $attributes = Arr::add($attributes, $relation->getForeignKeyName(), $this->{$relation->getLocalKeyName()});
        $model = $relation->getRelated();
        $model->fillAndSave($attributes);
        return $model;
    }

    public function deleteRelations(array $attributes): void
    {
        $relations = $this->getFillableRelations();
        foreach (Arr::only($attributes, array_keys($relations)) as $relation => $value) {
            switch ($relations[$relation]) {
                case RelationTypes::OneToOne:
                    if (empty($value['id'])) {
                        $this->{$relation}()->delete();
                    }
                    break;
                case RelationTypes::OneToMany:
                    $this->{$relation}()->whereNotIn('id', collect($value)->whereNotNull('id')->pluck('id'))->delete();
                    break;
                case RelationTypes::ManyToMany:
                    $this->{$relation}()->whereNotIn('id', collect($value)->whereNotNull('id')->pluck('id'))->detach();
            }
        }
    }
}
