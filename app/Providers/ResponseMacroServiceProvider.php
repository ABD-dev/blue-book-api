<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Query\Builder;

class ResponseMacroServiceProvider extends ServiceProvider
{
  public function boot()
  {
    Builder::macro('if', function ($condition, $column, $operator, $value) {
      if ($condition) {
          return $this->where($column, $operator, $value);
      }

      return $this;
    });
  }
}
