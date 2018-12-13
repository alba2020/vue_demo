@extends('admin.layouts.master')

@section('content')
<section class="content-header">
  <h1>
    {{ $page_title or "Заказы" }}
    <small>{{ $page_description or null }}</small>
  </h1>
</section>

<div id="data-orders-list" class="row">
  <div v-if="orders">
    <div class="col-lg-4 col-sm-5">
      <ul class="list-group box box-primary">
        <li class="list-group-item"  v-for = "order in orders" :key="order.id" @click="selectOrder(order.id)">
          <p class="numder-order">Номер заказа: @{{ order.id }}</p>
          <p class="address-order">Адрес заказа: @{{ order.address.address }}</p>
          <p class="total-order">Стоимость заказа: @{{ order.total }} руб. ( @{{ order.payment }} )</p>
          <p class="data-order">Дата заказа: @{{ order.created_at }} </p>
        </li>
      </ul>
    </div>

    <!-- <order-details :order="selectedOrder" v-if="selectedOrder"></order-details> -->

    <div class="col-lg-8 col-sm-7" v-if="selectedOrder">
      <ul class="list-group-item box box-primary">
        <p class="topic">id: @{{ selectedId }}</p>
        <li class="information">
          <p class="info-order">
            @{{ selectedOrder.customer.name }} :
            @{{ selectedOrder.customer.phone }} -
            @{{ selectedOrder.customer.email }}
          </p>
          <p class="order-address">
            Адрес: @{{ selectedOrder.address.address }},
            Кв.: @{{ selectedOrder.address.apartment }};
          </p>
          <p class="order-address">
            Способ доставки: @{{ selectedOrder.delivery }},
          </p>
        </li>
        <p class="list-order">Состав заказа:</p>
        <li class="list-group-item" v-for="item in selectedOrder.items">
          @{{ item.name }}
          @{{ item.count }} шт. -
          @{{ item.price }} руб/шт.
          Стоимость: @{{ item.total }} руб
        </li>
        <p class="total-cost">Итоговая стоимость: @{{ selectedOrder.total }} руб.</p>
        <p class="payment">Способ оплаты: @{{ selectedOrder.payment }} </p>
      </ul>
    </div>

  </div>
</div>

<script>
var rapp = new Vue({ el: '#data-orders-list',

data: {

  selectedId: null,

  orders: [],

},

methods: {
  selectOrder(orderId) {
    this.selectedId = orderId
  },
  downloadOrders() {
    axios.get('/api/orders')
    .then(response => {
      // console.log('data', response.data)
      const d = response.data.map(order => {
        let orderItems = []
        try {
          orderItems = JSON.parse(order.items)
        } catch (e) {
          console.log('Bad JSON:', e)
        }
        return {...order, items: orderItems}
      })
      // console.log('d', d)
      this.orders = d
    })
    .catch(err => console.log(err))
  }
},

computed: {
  selectedOrder() {
    if (!this.orders)
      return null
    if (!this.selectedId)
      return this.orders[0]
    else
      return this.orders.find(p => p.id === this.selectedId)
  }
},
created: function() {
  this.downloadOrders()
}
})

</script>

@endsection
