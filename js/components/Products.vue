<template>
  <div class="col-lg-8 col-sm-7">
    <div class="box box-primary" id="infos-app">
      <div class="box-header with-border">
        <h3 class="box-title">Товары</h3>
        <!-- pull-right -->
          <button type="button" @click="$emit('add-product')" class="btn btn-default btn-sm">
            <i class="fa fa-plus"></i>
          </button>
      </div>
      <div class="table-responsive mailbox-messages" id="products-list">
        <div class="mailbox-controls">
          <!-- <button type="button" class="btn btn-default btn-sm checkbox-toggle" disabled><i class="fa fa-square-o"></i>
          </button> -->
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-sm" disabled><i class="fa fa-eye" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-default btn-sm" disabled><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-default btn-sm" disabled><i class="fa fa-trash-o"></i></button>
          </div>
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-sm" disabled>Ещё</button>
            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-expanded="false" disabled>
              <span class="caret"></span>
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">Action</a></li>
              <li><a href="#">Another action</a></li>
              <li><a href="#">Something else here</a></li>
              <li class="divider"></li>
              <li><a href="#">Separated link</a></li>
            </ul>
          </div>
        </div>
        <div class="table-style">
          <table class="table">
            <thead class="row text-center group">
              <tr class="">
                <!-- <td class="box-input"></td>
                <td class="box-photo">Фото</td> -->
                <th class="box-name text-left">Название</th>
                <th class="box-name text-center">Изображение</th>
                <th class="box-code text-center">Артикул</th>
                <th class="box-price text-center">Цена</th>
                <th class="box-button"></th>
              </tr>
            </thead>
            <tbody class="row text-center group">
              <tr v-for="p in products" :key="p.id">
                <!-- <td class="box-input"><input type="checkbox"/></td>
                <td class="box-photo"> {{ p.img }} </td> -->
                <td class="box-name text-left">
                  <a href="#" @click.prevent="$emit('edit-product', p.id)">{{ p.name }}</a>
                </td>
                <td class="box-image">
                  <img class="table-preview" :src="'/storage/' + p.img_small" alt="preview">
                </td>
                <td class="box-code"> {{ p.article }} </td>
                <td class="box-price"> {{ p.price }} руб. </td>
                <td class="box-button">
                  <button @click="$emit('edit-product', p.id)" class="btn btn-default btn-sm">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                  </button>
                </td>
                <td class="box-button">
                  <button type="button" class="btn btn-default btn-sm" @click="$emit('delete-product', p.id)">
                    <i class="fa fa-trash-o"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['products']
}
</script>
