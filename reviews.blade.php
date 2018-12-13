@extends('admin.layouts.master')

@section('content')
  <section class="content-header">
      <h1>
          {{ $page_title or "Отзывы" }}
          <small>{{ $page_description or null }}</small>
      </h1>

      <!-- <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
          <li class="active">Here</li>
      </ol> -->
  </section>

<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Все отзывы</h3>
    <div class="box-tools pull-right">
      <div class="has-feedback">
        <input type="text" class="form-control input-sm" placeholder="Search Mail">
        <span class="glyphicon glyphicon-search form-control-feedback">
        </span>
      </div>
    </div>
    <!-- /.box-tools -->
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div class="pull-right">
      1-50/200
      <div class="btn-group">
        <button type="button" class="btn btn-default btn-sm">
          <i class="fa fa-chevron-left">
          </i>
        </button>
        <button type="button" class="btn btn-default btn-sm">
          <i class="fa fa-chevron-right">
          </i>
        </button>
      </div>
    </div>
  </div>
  <div class="table-responsive mailbox-messages" id="data-list">
    <table class="table table-hover table-striped">
      <tbody class="row text-center group">
        <tr v-for="r in reviews" :key="r.id">
          <td class="mailbox-name">
            @{{ r.name }} <br/>
          </td>
          <td class="mailbox-subject" :class="[r.accepted === 1 ? 'published' : 'unpublished']">@{{ r.text }}
          </td>
          <td class="mailbox-date">@{{ r.created_at }}</td>
          <td class="mailbox-publish">
            <button class="btn btn-default btn-sm" @click="onChangeStatus(r)">
              @{{ r.accepted ? 'Скрыть' : 'Показать' }}
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- /.table -->
  </div>

  <!-- /.box-body -->
  <div class="box-footer">
    <div class="pull-right">
      1-50/200
      <div class="btn-group">
        <button type="button" class="btn btn-default btn-sm">
          <i class="fa fa-chevron-left">
          </i>
        </button>
        <button type="button" class="btn btn-default btn-sm">
          <i class="fa fa-chevron-right">
          </i>
        </button>
      </div>
      <!-- /.pull-right -->
    </div>
  </div>
</div>
<script>

var rapp = new Vue({	el: '#data-list',
data: {
  reviews: [
    {
      id: '1',
      name: 'Коля',
      accepted: 1,
      text: 'Поели',
      created_at: '25.10.2018',
      mail: 'Bhhfvefh.@mayib.fg'
    },
    {
      id: '2',
      name: 'Вова',
      accepted: 0,
      text: 'Гречка - люби меня люби, ночью и днем, жарким огнем, серце зжигаяяяя',
      created_at: '25.10.2018',
      mail: 'Bhhfvefh.@mayib.fg'
    },
    {
      id: '3',
      name: 'Петя',
      accepted: 1,
      text: 'Фантастическая жратва',
      created_at: '25.10.2018',
      mail: 'Bhhfvefh.@mayib.fg'
    },
    {
      id: '4',
      name: 'Алина',
      accepted: 0,
      text: '',
      created_at: '25.10.2018',
      mail: 'Bhhfvefh.@mayib.fg'
    },
    {
      id: '5',
      name: 'Костя',
      accepted: 0,
      text: '',
      created_at: '25.10.2018',
      mail: 'Bhhfvefh.@mayib.fg'
    },
    {
      id: '6',
      name: 'Кирилл',
      accepted: 1,
      text: '***** какая-то',
      created_at: '25.10.2018',
      mail: 'Bhhfvefh.@mayib.fg'
    },
    {
      id: '7',
      name: 'Алина',
      accepted: 0,
      text: '',
      created_at: '25.10.2018',
      mail: 'Bhhfvefh.@mayib.fg'
    },
    {
      id: '8',
      name: 'Алина',
      accepted: 0,
      text: '',
      created_at: '25.10.2018',
      mail: 'Bhhfvefh.@mayib.fg'
    },
    {
      id: '9',
      name: 'Алина',
      accepted: 0,
      text: '',
      created_at: '25.10.2018',
      mail: 'Bhhfvefh.@mayib.fg'
    },
    {
      id: '10',
      name: 'Алина',
      accepted: 0,
      text: '',
      created_at: '25.10.2018',
      mail: 'Bhhfvefh.@mayib.fg'
    }
  ]
},
created: function() {
  this.downloadReviews();
},

methods: {
  downloadReviews: function() {
    axios.get('/api/reviews')
    .then(response => {
      let d = response.data
      const comparator = (x, y) => y.id - x.id
      d.sort(comparator) // sort by id desc
      this.reviews = d
    })
    .catch(err => console.log(err));
  },
  createReview: function(review) {
    axios.post('/api/reviews', {
      id: review.id,
      name: review.name,
      text: review.text,
    })
    .then(response => {
      console.log(response.data);
      this.downloadReviews();
    })
    .catch(error => console.log(error));
  },
  publishReview: function(id) {
      console.log('publish', id);
      axios.post(`/api/reviews/${id}/publish`)
        .then(response => {
            console.log(response.data)
            this.downloadReviews()
        })
        .catch(err => console.log(err))
  },
  unpublishReview: function(id) {
      console.log('unpublish', id)
      axios.post(`/api/reviews/${id}/unpublish`)
        .then(response => {
            console.log(response.data)
            this.downloadReviews()
        })
        .catch(err => console.log(err))
  },
  onChangeStatus: function(review) {
      console.log('change status', review.id)
      if (review.accepted === 0)
          this.publishReview(review.id)
      else if (review.accepted === 1)
          this.unpublishReview(review.id)
  }
}
});
</script>
@endsection
