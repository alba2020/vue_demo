<template>
  <div class="col-lg-8 col-sm-7">
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">id: {{ model.id }}
        </h3>
        <div class="pull-right">
        <span @click="$emit('select-category', model.id)" style="cursor: pointer" class="fa fa-close"></span>
        </div>
      </div>
      <form role="form">
        <div class="box-body">
          <div class="form-group">
            <label>Название</label>
            <input type="text" class="form-control" v-model="model.name">
          </div>
          <div class="form-group">
            <label>Описание</label>
            <textarea rows="5" name="text" class="form-control" v-model="model.description"></textarea>
          </div>
          <div class="form-group">
            <div class="checkbox">
              <label>
                <input type="checkbox" v-model="model.hidden">
                Скрыть категорию
              </label>
            </div>
          </div>
          <!--<div class="form-group">-->
            <!--<ul class="mailbox-attachments clearfix">-->
              <!--<li>-->
                <!--<span class="mailbox-attachment-icon has-img"><i class="fa fa-paperclip"></i></span>-->
                <!--<div class="mailbox-attachment-info">-->
                  <!--<a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> icon.svg</a>-->
                  <!--<span class="mailbox-attachment-size">-->
                    <!--max 1.9 MB-->
                    <!--<a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>-->
                  <!--</span>-->
                <!--</div>-->
              <!--</li>-->
            <!--</ul>-->
          <!--</div>-->

          <div class="form-group">
            <img :src="`/storage/${model.img}`" alt="изображение категории">
          </div>

          <div class="form-group">
            <label for="icon">Выберите изображение:</label>
            <input type="file" id="icon" name="icon" v-on:change="processFile($event)">
          </div>

          <div class="form-group">
            <div class="pull-right">
              <button type="button" @click="$emit('delete-category', model.id)" class="btn btn-default">
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
  props: ['category'],
  data: function() {
    return {
      model: { ...this.category },
      status: ''
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

      axios.post(`/api/categories/${this.model.id}`, formData, {
          // headers: {
          //   'Content-Type': 'multipart/form-data'
          // }
        })
        .then(res => {
          if (res.data.status === 'ok') {
            this.status = 'saved'

            return axios.get(`/api/categories/${this.model.id}`)
          }
        })
        .then(response => {
          this.model = response.data

          this.category.name = this.model.name //update tree
          this.category.hidden = this.model.hidden
          this.category.img = this.model.img
        })
        .catch(err => console.log(err))
    },
    onCancel() {
      this.model = { ...this.category }
    },
    processFile(event) {
      // this.model.icon = this.$refs.file.files[0];
      this.model.icon = event.target.files[0]
      console.log(this.model.icon)
    }
  }
}
</script>
