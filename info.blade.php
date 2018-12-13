@extends('admin.layouts.master')

@section('content')

<div class="box box-primary" id="infos-app">
  <div class="box-header with-border">
    <h3 class="box-title">Информация</h3>
    <div class="">

      <ul>
        <li v-for="i in infos" :key="i.id">
          @{{ i.name }} <input type="text" v-model="i.value" @keyup="sync()"/>
        </li>

        <i class="fa" :class="[status === 'changed' ? 'fa-hourglass' : '',
        status === 'saved' ? 'fa-chevron-down' : '']"></i>

      </ul>

    </div>
  </div>
</div>

<script>
    var iapp = new Vue({ el: '#infos-app',
        data: {
            timerId: 0,
            status: 'no change',
            infos: [
                {
                    id: 1,
                    name: 'n1',
                    value: 'v1'
                },
                {
                    id: 2,
                    name: 'n2',
                    value: 'v2'
                }
            ]
        },
        methods: {
            downloadAll() {
                axios.get('/api/info')
                    .then(response => {
                        this.infos = response.data
                    })
                    .catch(err => console.log(err));
            },
            sync() {
                this.status = 'changed'
                if (this.timerId) {
                    console.log('waiting for sync...')
                } else {
                    console.log('setting timer...')
                    this.timerId = setTimeout(this.synchronize, 3000)
                }
            },
            synchronize() {
                console.log('sync!')
                axios.put('/api/info/all', { infos: this.infos })
                .then(response => {
                    console.log(response.data)
                    this.status = 'saved'
                    this.timerId = 0
                })
                .catch(err => console.log(err))
            }
        },
        created: function() {
            this.downloadAll()
        }
    })
</script>


@endsection
