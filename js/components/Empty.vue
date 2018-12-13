<template>
    <div>
        <h1>this is template</h1>
        <h2>{{ msg }}</h2>
    </div>
</template>

<script>
  export default {
    props: ['p1', 'p2'],
    data: function() {
      return {
        state1: true,
        state2: false,
        msg: 'hello'
      }
    },
    methods: {
      m() {
       // todo method
      }
    },
    created: function() {
      console.log('created')
    }
  }
</script>
