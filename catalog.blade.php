@extends('admin.layouts.master')

@section('content')

    <section class="content-header">
        <h1>Каталог</h1>
    </section>
    <div id="catalog" class="row">
        <div class="col-lg-4 col-sm-5">
            <div class="box box-primary" id="infos-app">
                <div id="categories-app">
                    <div class="box-header with-border">
                        <h3 class="box-title">Категории</h3>
                        <additem class="btn-new-category" :pid="0" :items="items"></additem>
                    </div>
                    <ul class="open">
                        <item v-for="item in root"
                              :model="item"
                              :items="items"
                              :key="item.id"
                              :selected-id="selectedCategoryId"
                              @custom-event="onCustomEvent"></item>
                    </ul>
                    <modal-confirm
                            :title="confirmTitle"
                            :text="confirmText"
                            :resolve="confirmResolve"
                            :reject="confirmReject"
                            :set-status="setStatus" v-if="deleting"></modal-confirm>
                    <modal-error :msg="'Ошибка удаления'" v-if="error"></modal-error>
                </div>
            </div>
        </div>
        <products v-if="mode==='products'"
                  :category-id="selectedCategoryId"
                  :products="selectedProducts"
                  @delete-product="deleteProduct"
                  @edit-product="editProduct"
                  @add-product="addProduct"
        ></products>
        <category-card v-if="mode==='category-card'"
                       :category="selectedCategory"
                       @select-category="selectCategory"
                       @delete-category="deleteCategory"
        ></category-card>
        <product-card v-if="mode==='product-card'"
                      :product="selectedProduct"
                      @select-category="selectCategory"
                      @delete-product="deleteProduct"
        ></product-card>
    </div>

    <script type="text/javascript">
      var capp = new Vue({
        el: '#catalog',

        data: {
          items: [],
          deleting: false,
          confirmTitle: '',
          confirmText: '',
          confirmResolve: '',
          confirmReject: '',
          error: false,
          status: '',
          selectedCategoryId: null,
          selectedProductId: null,
          products: [],
          mode: 'products'
        },

        methods: {
          setStatus(s) {
            this.status = s
          },
          // --------- categories -----------------
          selectCategory(id) {
            this.selectedCategoryId = id
            this.mode = 'products'
          },
          deleteCategory(id) {
            let deleteMessage = 'Вы уверены, что хотите удалить категорию?'
            if (this.items.find(i => i.parent_id === id))
              deleteMessage = 'Удаление приведет к удалению всех подкатегорий. Продолжить?'

            const parent_id = this.items.find(i => i.id === id).parent_id

            this.confirmDelete('Удалить', deleteMessage, 'Удалить', 'Отмена')
              .then(() => axios.delete(`/api/categories/${id}`))
              .then(response => this.downloadCategories())
              .then(() => this.selectCategory(parent_id))
              .catch(err => {
                if (err !== 'cancel') {
                  console.log(err)
                  this.error = true
                  setTimeout(() => { this.error = false }, 2000)
                }
              })
          },
          downloadCategories() {
            return axios.get('/api/categories')
              .then(response => {
                this.items = response.data
              })
              .catch(err => console.log(err));
          },

          // --------- products -------------------
          deleteProduct(id) {
            const c_id = this.products.find(i => i.id === id).category_id
            this.confirmDelete('Удалить', 'Удалить товар?', 'Удалить', 'Отмена')
              .then(() => axios.delete(`/api/dishes/${id}`))
              .then(response => this.downloadProducts())
              .then(() => this.selectCategory(c_id))
              .catch(err => {
                if (err !== 'cancel') {
                  console.log(err)
                  this.error = true
                  setTimeout(() => { this.error = false }, 2000)
                }
              })
          },
          downloadProducts() {
            return axios.get('/api/dishes')
              .then(response => {
                this.products = response.data
              })
              .catch(err => console.log(err));
          },
          editProduct(id) {
            this.selectedProductId = id
            // console.log('selectedProductId', this.selectedProductId)
            this.mode = 'product-card'
          },
          addProduct() {
            axios.post('/api/dishes/create', {
              category_id: this.selectedCategoryId
            })
            .then(response => {
                if (response.data.status === 'ok') {
                  this.products.push(response.data.dish)
                  this.editProduct(response.data.id)
                } else {
                  console.log('error', data)
                }
            })
            .catch(err => console.log(err))
          },
          // -------------- misc ---------------
          onCustomEvent(e) {
            switch (e.type) {
              case 'delete':
                // console.log('delete id', e.data)
                this.deleteCategory(e.data)
                break

              case 'select':
                // console.log('selected category id', e.data)
                this.selectCategory(e.data)
                break

              case 'view_category_card':
                // console.log('view category id', e.data)
                this.selectedCategoryId = e.data
                this.mode = 'category-card'
                break

              default:
                console.log('unknown custom event')
            }
          },
          confirmDelete(title, text, resolve, reject) {
            this.confirmTitle = title
            this.confirmText = text
            this.confirmResolve = resolve
            this.confirmReject = reject

            this.deleting = true
            let timerId = null

            const closeConfirm = () => {
              this.deleting = false
              clearInterval(timerId)
              this.status = ''
            }

            return new Promise((resolve, reject) => {
              timerId = setInterval(() => {
                // console.log('tick')

                if (this.status === 'yes') {
                  closeConfirm()
                  resolve()
                }
                else if (this.status === 'no') {
                  closeConfirm()
                  reject('cancel')
                }
              }, 300)
            })
          }
        },
        created: function () {
          this.downloadCategories()
          this.downloadProducts()
        },
        computed: {
          root() {
            return this.items.filter(item => item.parent_id == 0)
          },
          selectedCategory() {
            return this.selectedCategoryId
              ? this.items.find(c => c.id == this.selectedCategoryId)
              : null
          },
          selectedProduct() {
            return this.selectedProductId
              ? this.products.find(p => p.id == this.selectedProductId)
              : null
          },
          selectedProducts() {
            return this.selectedCategoryId ?
              this.products.filter(p => p.category_id == this.selectedCategoryId)
              : []
          }
        }

      })
    </script>

@endsection
