<template>
  <div>

    <input type="text" :value="model.name" @input="onChange($event)"/>
    <i v-if="status === 'changed'" class="fa fa-hourglass"></i>
    <i v-if="status === 'saved'" class="fa fa-chevron-down"></i>

  </div>
</template>

<script>
  export default {
    props: ['tag'],
    data: function() {
      return {
        status: 'not changed',
        timerID: null,
        model: {
          name: this.tag.name
        }
      }
    },
    methods: {
      onChange(e) {
        this.model.name = e.target.value
        // console.log('change', this.tag.id)
        this.status = 'changed'

        if (this.timerId) {
          console.log('waiting for sync...')
        } else {
          console.log('setting timer...')
          this.timerId = setTimeout(this.synchronize, 3000)
        }
      },
      synchronize() {
        this.timerId = null

        axios.put('/api/tags/' + this.tag.id, { name: this.model.name })
          .then(response => {
            return axios.get('/api/tags/' + this.tag.id)
          })
          .then( ({ data }) => {
            this.model.name = data.name
            this.tag.name = data.name // update in collection

            this.status = 'saved'
            this.timerId = null
          })
          .catch(err => console.log(err))
      }
    }
  }
</script>
