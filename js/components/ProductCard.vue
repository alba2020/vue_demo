<template>
  <div class="col-lg-8 col-sm-7 product-card">
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">id: {{ model.id }}
        </h3>
        <div class="pull-right">
        <span @click="$emit('select-category', model.category_id)" style="cursor: pointer" class="fa fa-close"></span>
        </div>
      </div>
      <form role="form">
        <div class="box-body">
          <div class="form-group">
            <label>Название</label>
            <input type="text" class="form-control" v-model="model.name">
          </div>
          <div class="form-group">
            <label>Артикул</label>
            <input type="text" class="form-control" v-model="model.article">
          </div>
          <div class="form-group">
            <label>Единица измерения</label>
            <select v-model="model.unit">
              <option disabled value="">Выберите единицу измерения</option>
              <option value="кг">килограмм (кг)</option>
              <option value="г">грамм (г)</option>
              <option value="л">литр (л)</option>
              <option value="мл">миллилитр (мл)</option>
              <option value="шт">предмет (шт)</option>
            </select>
          </div>
          <div class="form-group">
            <label>Количество</label>
            <input type="text" class="form-control" :value="model.quantity" @input="onChangeQuantity($event)">
          </div>
          <div class="form-group">
            <label>Цена</label>
            <input type="text" class="form-control" v-model="model.price">
          </div>
          <div class="form-group">
            <label>Описание</label>
            <textarea rows="5" name="text" class="form-control" v-model="model.description"></textarea>
          </div>
          <!--<div class="form-group">-->
                  <!--<label>Выбрать категорию</label>-->
                  <!--<select class="form-control">-->
                    <!--<option>option 1</option>-->
                    <!--<option>option 2</option>-->
                    <!--<option>option 3</option>-->
                    <!--<option>option 4</option>-->
                    <!--<option>option 5</option>-->
                  <!--</select>-->
          <!--</div>-->
          <div class="form-group">
            <label>Категория</label>
            <input class="form-control" type="text" v-model="model.category_id">
          </div>
          <div class="form-group">
            <div class="checkbox">
              <label>
                <input type="checkbox" v-model="model.hidden">
                Скрыть продукт
              </label>
            </div>
          </div>
          <div class="form-group">
            <img :src="`/storage/${model.img_mid}`" alt="изображение продукта" class="product-image">
          </div>

          <div class="form-group">
            <label for="icon">Выберите изображение:</label>
            <input type="file" id="icon" name="icon" v-on:change="processFile($event)">
            <img v-if="url" :src="url" class="preview-image"/>
          </div>

          <div class="form-group">
            <div class="pull-right">
              <button type="button" @click="$emit('delete-product', model.id)" class="btn btn-default">
                <i class="fa fa-trash-o"></i> Удалить</button>
            </div>

            <button type="button" @click="onSave" class="btn btn-default">
              <i class="fa fa-floppy-o"></i> Сохранить</button>

            <i class="fa" :class="[status === 'saving' ? 'fa-hourglass' : '',
              status === 'saved' ? 'fa-chevron-down' : '']"></i>

            <button type="button" @click="onCancel" class="btn btn-default">
              <i class="fa fa-reply"></i> Отменить</button>

          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
  export default {
    // product - параметры, model - копия для работы
    props: ['product', 'select', 'delete'],
    data: function() {
      return {
        model: { ...this.product },
        status: '',
        url: null
      }
    },
    methods: {
      onSave() {
        this.status = 'saving'

        let formData = new FormData()
        for (const field in this.model){
          formData.append(field, this.model[field])
        }
        formData.append('_method', 'PUT');

        axios.post(`/api/dishes/${this.model.id}`, formData)
          .then(res => {
            if (res.data.status === 'ok') {
              this.status = 'saved'
              this.model = res.data.dish
              this.url = null

              for (const field in res.data.dish) {
                this.product[field] = res.data.dish[field]
              }

            }
          })
          .catch(err => console.log(err))
      },
      onCancel() {
        this.model = { ...this.product }
      },
      processFile(event) {
        this.model.icon = event.target.files[0]
        this.url = URL.createObjectURL(this.model.icon)
        // console.log(this.model.icon)
      },
      onChangeQuantity(e) {
        this.model.quantity = e.target.value.replace(',', '.')
      }
    }
  }
</script>
