<template>

  <li class="category-input">

    <div class="input-group input-group-sm" :class="{ 'selected': isSelected, 'edit': edit }">
      <span v-if="children.length" class="input-group-btn" @click="onExpand()">
        <span class="btn btn-default"><i class="fa fa-angle-right" v-bind:class="{ isOpen : open  }"></i>
        </span>
      </span>
      <input type="text" style="cursor: pointer" :readonly="!edit"
             @click="onSelectItemAction"
             @keydown.enter="onSave"
             @dblclick="viewCategoryCard"
             class="form-control" v-model="model.name">
      <span v-if="model.hidden" class="input-group-addon"><i class="fa fa-eye-slash"></i></span>
      <!--<span style="cursor: pointer" @click="onSelectItemAction">-->
      <!--{{ model.name }}-->
      <!--</span>-->

      <!--<span type="text" style="cursor: pointer" :readonly="!edit"-->
      <!--@click="onSelectItemAction"-->
      <!--@keydown.enter="edit=false"-->
      <!--class="form-control">-->
      <!--{{ model.name }}-->
      <!--</span>-->

      <span class="input-group-btn">
        <button v-if="edit" @click="onSave" class="btn btn-default dropdown-toggle"><i class="fa fa-floppy-o"></i></button>
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false"><span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
          <li><a href="#" @click="addChild"><i class="fa fa-plus"></i>Создать подкатегорию</a></li>
          <li class="divider"></li>
          <li><a href="#" @click="viewCategoryCard"><i class="fa fa-cog" aria-hidden="true"></i>Настроить категорию</a></li>
          <li><a href="#" @click="onEdit"><i class="fa fa-edit"></i>Переименовать категорию</a></li>
          <li><a href="#" @click="onDeleteItemAction"><i class="fa fa-trash-o"></i>Удалить категорию</a></li>
        </ul>
        <!-- end -->
      </span>
    </div>
    <ul class="open-category" v-if="open">
      <item v-for="item in children"
            :model="item"
            :items="items"
            :key="item.id"
            :selected-id="selectedId"
            @custom-event="passEvent"></item>
    </ul>
  </li>
</template>
<script>
  // @click="!edit && onExpand()
  export default {
    props: ['model', 'items', 'selectedId'],

    data: function () {
      return {
        open: false,
        edit: false
      }
    },

    methods: {
      onEdit() {
        this.edit = true
      },
      onSave() {
        this.edit = false

        const newName = this.model.name
        this.model.name = "Сохраняем...";

        axios.post(`/api/categories/${this.model.id}/rename`, {
          name: newName
        })
        .then(response => {
          if (response.data.status === 'ok')
            this.model.name = response.data.name
        })
        .catch(err => console.log(err))

      },
      onExpand() {
        this.open = !this.open
      },
      onDeleteItemAction() {
        // console.log('delete button pressed')
        this.$emit('custom-event', {type: 'delete', data: this.model.id})
      },
      onSelectItemAction() {
        this.$emit('custom-event', {type: 'select', data: this.model.id})
      },
      viewCategoryCard() {
        this.$emit('custom-event', {type: 'view_category_card', data: this.model.id})
      },
      passEvent(e) {
        // console.log('custom event handler in', this.model.name)
        this.$emit('custom-event', e)
      },
      addChild() {
        axios.post('/api/categories/create', {
          parent_id: this.model.id,
          name: prompt('Введите название')
        }).then(response => {
          if (response.data.status === 'ok') {
            this.items.push({
              id: response.data.id,
              parent_id: response.data.parent_id,
              name: response.data.name,
              description: response.data.description,
              img: response.data.img,
              hidden: response.data.hidden
            })
            this.open = true
          } else {
            console.log('error', data)
          }
        })
          .catch(err => console.log(err))
      },
      rename() {

      }
    },

    computed: {
      children: function () {
        return this.items.filter(item => item.parent_id === this.model.id)
      },
      isSelected() {
        // return this.model.id === capp.selectedCategoryId
        return this.model.id === this.selectedId
      }
    }
  }
</script>
