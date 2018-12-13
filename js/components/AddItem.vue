<template>
    <div class="btn-group category-plus">
        <!--<button type="button" class="btn btn-default btn-sm">Создать</button>-->
        <button type="button" class="btn btn-default btn-sm" @click="onAdd()"> <i class="fa fa-plus"></i></button>
    </div>
</template>

<script>
    export default {
        props: ['pid', 'items'],
        methods: {
            onAdd() {
                axios.post('/api/categories/create', {
                  parent_id: this.pid,
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
                  } else {
                    console.log('error', data)
                  }
                })
                .catch(err => console.log(err))

                // const rnd = Math.floor(Math.random() * 1000000).toString(32)
                // this.items.push({
                //     id: rnd,
                //     parent_id: this.pid,
                //     name: 'item ' + rnd
                // })
            }
        }
    }
</script>
