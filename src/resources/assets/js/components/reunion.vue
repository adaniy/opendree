<template>
  <div class="module-reunion">
    <div class="col-md-12 header">
      <div class="col-md-10 search">
        <div class="search-result vcenter">
          64 résultat(s)
        </div>

        <div class="search-form">
          <form class="form form-inline">

            <div class="form-group form-search">
              <input type="text" name="nom" class="form-control" placeholder="Sujet à rechercher ..." />
            </div>

            <div class="form-group form-search">
              <input type="text" name="date" class="form-control" placeholder="Date à rechercher ..." />
            </div>
          </form>
        </div>
      </div>

      <div class="col-md-2 options text-right">
        <div class="pagination">
          <button class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-chevron-left"></span></button>
          <div class="number"><strong>1</strong> sur 10</div>
          <button class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-chevron-right"></span></button>
        </div>
      </div>
    </div>
    <div class="col-md-12 container">
      <div class="col-md-4 block">
        <div class="block-header">Réunion budgétaire importante /!\</div>

        <div class="block-container">
	  <div class="category-title">Test titre</div>
        </div>

        <div class="block-footer">
	  <div class="category-title">Test titre</div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--
<button class="btn btn-md btn-primary" v-on:click="modalEditSubjectShow = !modalEditSubjectShow">Show modal !</button>
<transition name="modal">
    <modalEditSubject v-if="modalEditSubjectShow" @close="modalEditSubjectShow = false"></modalEditSubject>
</transition>
-->
  </template>

<script>
  /** Inserting modals components */
  import ModalEditSubject from './modal/reunion/edit/subject.vue';

export default {
    data () {
        return {
            modalEditSubjectShow: false
        }
    },
    components: {
        modalEditSubject: ModalEditSubject
    }
}
                            </script>
