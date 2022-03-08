<template>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="">Judul Modul <span class="text-danger">*</span></label>
        <input v-model="title" type="text" class="form-control" placeholder="contoh: Produk" />
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="">Ikon <span class="text-danger">*</span></label>
        <input v-model="icon" type="text" class="form-control" placeholder="contoh: users" />
        <span class="text-hint">
          Bisa cek di
          <a target="_blank" href="https://fontawesome.com/icons"> https://fontawesome.com/icons </a>
        </span>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label for="">Nama Model <span class="text-danger">*</span></label>
        <input v-model="modelName" type="text" class="form-control" placeholder="contoh: Product" />
      </div>
    </div>

    <div class="col-md-12" v-for="(column, index) in columns" :key="index">
      <h5 class="text-danger">Kolom Ke {{ index + 1 }}</h5>
      <div class="row">
        <div class="col-md-12">
          <h6 class="text-primary">Migrations</h6>
          <div class="form-group">
            <label for="">Nama Kolom <span class="text-danger">*</span></label>
            <input v-model="column.name" type="text" class="form-control" placeholder="contoh: name atau id atau apa gitu" />
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="">Tipe <span class="text-danger">*</span></label>
            <select @change="onChangeType($event, index)" v-model="column.type" name="" id="" class="form-control">
              <option value="bigIncrements">bigIncrements</option>
              <option value="increments">increments</option>
              <option value="tinyIncrements">tinyIncrements</option>
              <option value="varchar">varchar</option>
              <option value="boolean">boolean</option>
              <option value="text">text</option>
              <option value="longText">longText</option>
              <option value="double">double</option>
              <option value="bigInteger">bigInteger</option>
              <option value="integer">integer</option>
              <option value="unsignedBigInteger">unsignedBigInteger</option>
              <option value="unsignedInteger">unsignedInteger</option>
              <option value="tinyInteger">tinyInteger</option>
              <option value="date">date</option>
              <option value="time">time</option>
              <option value="datetime">datetime</option>
              <option value="rememberToken">rememberToken</option>
              <option value="uuid">uuid</option>
            </select>
          </div>
        </div>
        <div class="col-md-3" v-if="!column.isAi">
          <div class="form-group">
            <label for="">Length <span class="text-danger">*</span></label>
            <input :disabled="column.type != 'varchar'" type="number" v-model="column.column_length" class="form-control" placeholder="contoh: 191" />
          </div>
        </div>
        <div class="col-md-3" v-if="!column.isAi">
          <div class="form-group">
            <label for="">Default</label>
            <input type="text" v-model="column.column_default" class="form-control" placeholder="contoh: lorem ipsum" />
          </div>
        </div>
        <div class="col-md-3" v-if="!column.isAi">
          <div class="form-group">
            <label for="">
              <!-- Nullable <span class="text-danger">*</span> -->
            </label>
            <div class="selectgroup selectgroup-pills">
              <label class="selectgroup-item">
                <input v-model="column.nullable" type="checkbox" name="name" value="" class="selectgroup-input" />
                <span class="selectgroup-button">Nullable</span>
              </label>
              <label class="selectgroup-item">
                <input v-model="column.unique" type="checkbox" name="name" value="" class="selectgroup-input" />
                <span class="selectgroup-button">Unique</span>
              </label>
            </div>
          </div>
        </div>
        <div class="col-12" v-if="!column.isAi">
          <input type="checkbox" v-model="column.isForeignKey" />
          Foreign Key
          <div class="row" v-if="column.isForeignKey">
            <div class="col-md-3">
              <div class="form-group">
                <label for="">On</label>
                <input type="text" v-model="column.foreign.on" class="form-control" placeholder="contoh: users" />
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="">On</label>
                <input type="text" v-model="column.foreign.references" class="form-control" placeholder="contoh: id" />
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="">On Update <span class="text-danger">*</span></label>
                <select v-model="column.foreign.onUpdate" name="" id="" class="form-control">
                  <option value="cascade">cascade</option>
                  <option value="set null">set null</option>
                  <option value="restrict">restrict</option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="">On Delete <span class="text-danger">*</span></label>
                <select v-model="column.foreign.onDelete" name="" id="" class="form-control">
                  <option value="cascade">cascade</option>
                  <option value="set null">set null</option>
                  <option value="restrict">restrict</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 mb-4" v-if="!column.isAi">
          <a href="https://laravel.com/docs/8.x/migrations#available-column-types" target="_blank"> https://laravel.com/docs/8.x/migrations#available-column-types </a>
        </div>

        <div class="col-12" v-if="!column.isAi">
          <h6 class="text-primary">Tampilan Form</h6>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="">Label <span class="text-danger">*</span></label>
                <input v-model="column.form.label" type="text" class="form-control" placeholder="contoh: Nama Lengkap" />
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label for="">Jenis Form <span class="text-danger">*</span></label>
                <select v-model="column.form.type" name="" id="" class="form-control">
                  <option value="inputtext">inputtext</option>
                  <option value="inputnumber">inputnumber</option>
                  <option value="inputdate">inputdate</option>
                  <option value="inputemail">inputemail</option>
                  <option value="inputtime">inputtime</option>
                  <option value="inputpassword">inputpassword</option>
                  <option value="inputcheckbox">inputcheckbox</option>
                  <option value="inputradio">inputradio</option>
                  <option value="textarea">textarea</option>
                  <option value="select">select</option>
                  <option value="select2">select2</option>
                  <option value="selectmultiple">selectmultiple</option>
                  <option value="select2multiple">select2multiple</option>
                  <option value="colorpicker">colorpicker</option>
                  <option value="summernote">summernote</option>
                </select>
              </div>
            </div>

            <div class="col-12">
              Validation saat store
              <div class="row">
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="bail" /> bail</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="nullable" /> nullable</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="required" /> required</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="numeric" /> numeric</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="integer" /> integer</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="confirmed" /> confirmed</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="boolean" /> boolean</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="date" /> date</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="date_format:Y-m-d" /> date_format:Y-m-d</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="date_format:H:i:s" /> date_format:H:i:s</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="email" /> email</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="url" /> url</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="active_url" /> active_url</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="file" /> file</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="image" /> image</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="mimes:png,jpeg,jpg" /> mimes:png,jpeg,jpg</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="mimes:xls,xlsx,csv" /> mimes:xls,xlsx,csv</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="mimes:pdf" /> mimes:pdf</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="mimes:doc,docx" /> mimes:doc,docx</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="file" /> file</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="ip" /> ip</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="ipv4" /> ipv4</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="ipv6" /> ipv6</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="uuid" /> uuid</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="string" /> string</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="json" /> json</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="array" /> array</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="filled" /> filled</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="alpha" /> alpha</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="alpha_dash" /> alpha_dash</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="alpha_num" /> alpha_num</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="filled" /> filled</div>
                <div class="col-md-2"><input v-model="column.form.validations.store" type="checkbox" value="accepted" /> accepted</div>
                <div class="col-12 mt-3">
                  <div class="form-group">
                    <label for="">Custom validation saat store </label>
                    <input v-model="column.form.validations.store_custom" type="text" class="form-control" placeholder="contoh: min:8|max:100" />
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12">
              Validation saat update
              <div class="row">
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="bail" /> bail</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="nullable" /> nullable</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="required" /> required</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="numeric" /> numeric</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="integer" /> integer</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="confirmed" /> confirmed</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="boolean" /> boolean</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="date" /> date</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="date_format:Y-m-d" /> date_format:Y-m-d</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="date_format:H:i:s" /> date_format:H:i:s</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="email" /> email</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="url" /> url</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="active_url" /> active_url</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="file" /> file</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="image" /> image</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="mimes:png,jpeg,jpg" /> mimes:png,jpeg,jpg</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="mimes:xls,xlsx,csv" /> mimes:xls,xlsx,csv</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="mimes:pdf" /> mimes:pdf</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="mimes:doc,docx" /> mimes:doc,docx</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="file" /> file</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="ip" /> ip</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="ipv4" /> ipv4</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="ipv6" /> ipv6</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="uuid" /> uuid</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="string" /> string</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="json" /> json</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="array" /> array</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="filled" /> filled</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="alpha" /> alpha</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="alpha_dash" /> alpha_dash</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="alpha_num" /> alpha_num</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="filled" /> filled</div>
                <div class="col-md-2"><input v-model="column.form.validations.update" type="checkbox" value="accepted" /> accepted</div>
                <div class="col-12 mt-3">
                  <div class="form-group">
                    <label for="">Custom validation saat update </label>
                    <input v-model="column.form.validations.update_custom" type="text" class="form-control" placeholder="contoh: min:8|max:100" />
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 mt-3">
              <a href="https://laravel.com/docs/8.x/validation#available-validation-rules" class="text-primary" target="_blank"> https://laravel.com/docs/8.x/validation#available-validation-rules </a>
            </div>
            <div class="col-12" v-if="index !== 0">
              <a @click.prevent="deleteColumn(index)" href="" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus Kolom</a>
            </div>
          </div>
        </div>
      </div>
      <hr />
    </div>
    <div class="col-12">
      <div class="form-group">
        <label for="">
          <!-- Nullable <span class="text-danger">*</span> -->
        </label>
        <div class="selectgroup selectgroup-pills">
          <label class="selectgroup-item">
            <input type="checkbox" name="name" value="" class="selectgroup-input" v-model="timestamps" />
            <span class="selectgroup-button">timestamps</span>
          </label>
        </div>
      </div>
    </div>
    <div class="col-12 mb-5">
      <a href="" class="btn btn-primary" @click.prevent="pushColumn"><i class="fa fa-plus"></i></a>
    </div>
    <div class="col-12">
      <a @click.prevent="onGenerate" href="" :class="`btn btn-primary ${isProcessing ? 'disabled' : ''}`"> <i class="fa fa-check"></i> {{ isProcessing ? 'Memproses...' : 'Generate' }} </a>
    </div>
    <div class="col-12 mt-3" v-if="logs.length > 0">
      <h6 class="text-primary">Silakan cek beberapa file yang tergenerate di bawah</h6>
      <div v-for="(log, index) in logs" :key="index">
        {{ log }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isProcessing: false,
      logs: [],

      // title: 'Produk',
      // icon: 'cubes',
      // modelName: 'Product',
      // timestamps: true,
      // columns: [
      //   {
      //     name: 'id',
      //     type: 'bigIncrements',
      //     column_length: null,
      //     column_default: null,
      //     nullable: false,
      //     form: {
      //       label: 'id',
      //       type: 'inputtext',
      //       validations: {
      //         store: ['required'],
      //         update: ['required'],
      //         store_custom: null,
      //         update_custom: null,
      //       },
      //     },
      //   },
      //   {
      //     name: 'category_id',
      //     type: 'unsignedBigInteger',
      //     column_length: 20,
      //     column_default: null,
      //     nullable: false,
      //     isForeignKey: true,
      //     foreign: {
      //       on: 'users',
      //       references: 'id',
      //       onUpdate: 'cascade',
      //       onDelete: 'set null',
      //     },
      //     form: {
      //       label: 'Kategori',
      //       type: 'select',
      //       validations: {
      //         store: ['required'],
      //         update: ['required'],
      //         store_custom: null,
      //         update_custom: null,
      //       },
      //     },
      //   },
      //   {
      //     name: 'name',
      //     type: 'varchar',
      //     column_length: 20,
      //     column_default: 'hehe',
      //     nullable: true,
      //     unique: true,
      //     foreign: {
      //       on: null,
      //       references: null,
      //       onUpdate: null,
      //       onDelete: null,
      //     },
      //     form: {
      //       label: 'Name',
      //       type: 'inputtext',
      //       validations: {
      //         store: ['required'],
      //         update: ['required'],
      //         store_custom: null,
      //         update_custom: null,
      //       },
      //     },
      //   },
      //   {
      //     name: 'birth_date',
      //     type: 'date',
      //     column_length: 20,
      //     column_default: null,
      //     nullable: false,
      //     foreign: {
      //       on: null,
      //       references: null,
      //       onUpdate: null,
      //       onDelete: null,
      //     },
      //     form: {
      //       label: 'Birth Date',
      //       type: 'inputdate',
      //       validations: {
      //         store: ['required'],
      //         update: ['required'],
      //         store_custom: 'date_format:Y-m-d',
      //         update_custom: 'date_format:Y-m-d',
      //       },
      //     },
      //   },
      //   {
      //     name: 'email',
      //     type: 'varchar',
      //     column_length: 20,
      //     column_default: null,
      //     nullable: false,
      //     foreign: {
      //       on: null,
      //       references: null,
      //       onUpdate: null,
      //       onDelete: null,
      //     },
      //     form: {
      //       label: 'Email',
      //       type: 'email',
      //       validations: {
      //         store: ['required'],
      //         update: ['required'],
      //         store_custom: 'email',
      //         update_custom: 'date_format:Y-m-d',
      //       },
      //     },
      //   },
      // ],

      title: '',
      icon: '',
      modelName: '',
      timestamps: true,
      columns: [
        {
          name: null,
          type: 'bigIncrements',
          column_length: null,
          column_default: null,
          nullable: false,
          isAi: true,
          foreign: {
            on: null,
            references: null,
            onUpdate: null,
            onDelete: null,
          },
          form: {
            label: '',
            type: 'inputtext',
            validations: {
              store: ['required'],
              update: ['required'],
              store_custom: null,
              update_custom: null,
            },
          },
        },
      ],
    };
  },

  watch: {
    title(newValue) {
      this.modelName = this.toTitleCase(newValue);
    },
  },

  methods: {
    toTitleCase(str) {
      const newStr = str
        .split(' ')
        .map((w) => w?.[0]?.toUpperCase() + w.substring(1).toLowerCase())
        .join(' ');
      return newStr;
    },

    pushColumn() {
      this.columns.push({
        name: null,
        type: 'varchar',
        column_length: null,
        column_default: null,
        nullable: false,
        isAi: false,
        foreign: {
          on: null,
          references: null,
          onUpdate: null,
          onDelete: null,
        },
        form: {
          label: '',
          type: 'inputtext',
          validations: {
            store: ['required'],
            update: ['required'],
            store_custom: null,
            update_custom: null,
          },
        },
      });
    },

    onChangeType(e, index) {
      console.log(e.target.value);
      let column = null;
      if (e.target.value === 'varchar') {
        column = { ...this.columns[index], column_length: 191, isAi: false };
      } else if (e.target.value === 'bigIncrements' || e.target.value === 'tinyIncrements' || e.target.value === 'increments' || e.target.value === 'rememberToken') {
        column = { ...this.columns[index], column_length: null, isAi: true };
      } else {
        column = { ...this.columns[index], column_length: null, isAi: false };
      }
      let columns = [...this.columns];
      columns[index] = column;
      this.columns = columns;
    },

    onGenerate() {
      if (this.isProcessing === false) {
        if (!this.title) {
          alert('Judul modul required');
          return;
        }
        if (!this.title) {
          alert('Ikon required');
          return;
        }
        if (!this.title) {
          alert('Nama model required');
          return;
        }
        this.isProcessing = true;
        this.logs = [];
        // console.log(this.columns);
        const data = {
          title: this.title,
          icon: this.icon,
          modelName: this.modelName,
          columns: this.columns,
          timestamps: this.timestamps,
        };
        window.axios
          .post('crud-generator', data)
          .then((res) => {
            // console.log(res.data);
            this.logs = res.data.data;
            swal('Good job!', 'CRUD Berhasil dilakukan', 'success');
          })
          .finally(() => {
            this.isProcessing = false;
          });
      }
    },

    deleteColumn(index) {
      this.columns.splice(index, 1);
    },
  },
};
</script>

<style></style>
