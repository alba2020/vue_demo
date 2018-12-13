<template>
    <div class="modal fade in" style="display: block;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" @click="onReject">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">{{ title }}</h4>
                </div>
                <div class="modal-body">
                    <p>{{ text }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" @click="onReject">{{ reject }}</button>
                    <button type="button" class="btn btn-danger" @click="onResolve">{{ resolve }}</button>
                </div>
            </div> <!-- /.modal-content -->
        </div> <!-- /.modal-dialog -->
    </div>
</template>

<script>
  export default {

    props: ['setStatus', 'title', 'text', 'resolve', 'reject'],

    methods: {
      onResolve() {
        // console.log('resolve')
        this.setStatus('yes')
      },
      onReject() {
        // console.log('reject')
        this.setStatus('no')
      }
    }
  }
</script>
