<template>
    <div class="modal fade in" style="display: block;">
        <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">

                <!--<button type="button" class="close" @click="reject">-->
                  <!--<span aria-hidden="true">×</span></button>-->

                  <h4 class="modal-title">Ошибка</h4>
              </div>
                <div class="modal-body">
                    <p>{{ msg }}</p>
                </div>
            </div> <!-- /.modal-content -->
        </div> <!-- /.modal-dialog -->
    </div>
</template>

<script>
  export default {

    props: ['msg']

  }
</script>
