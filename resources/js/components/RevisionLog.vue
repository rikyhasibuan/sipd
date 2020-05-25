<template>
  <div style="margin-bottom:35px;">
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
          <a class="nav-link" href="#revlogkassubag" role="tab" data-toggle="tab">
            <span v-if="revision.kassubag.approval === 1"><i class="fa fa-check"></i>&nbsp;</span>Catatan Revisi Kassubag
          </a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="#revlogsekretaris" role="tab" data-toggle="tab">
            <span v-if="revision.sekretaris.approval === 1"><i class="fa fa-check"></i>&nbsp;</span>Catatan Revisi Sekretaris
          </a>
      </li>
      <li class="nav-item">
          <a class="nav-link active" href="#revloginspektur" role="tab" data-toggle="tab">
            <span v-if="revision.inspektur.approval === 1"><i class="fa fa-check"></i>&nbsp;</span>Catatan Revisi Inspektur
          </a>
      </li>
    </ul>

    <div class="tab-content">
      <div role="tabpanel" class="tab-pane fade in show active" id="revloginspektur">
        <div style="margin-top:10px;"></div>
        <div class="direct-chat-messages" style="height:auto !important;" v-if="revision.inspektur.catatan.length > 0">
          <div class="direct-chat-msg">
            <div class="direct-chat-text" style="margin-left: 0px !important;" v-for="v in revision.inspektur.catatan" :key="v">
              {{ v }}
            </div>
          </div>
        </div>
        <div class="alert alert-danger" role="alert"  style="text-align: center;">
            <i class="fa fa-exclamation-triangle"></i> TIDAK ADA CATATAN REVISI
        </div>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="revlogsekretaris">
        <div style="margin-top:10px;"></div>
        <div class="direct-chat-messages" style="height:auto !important;" v-if="revision.sekretaris.catatan.length > 0">
          <div class="direct-chat-msg">
            <div class="direct-chat-text" style="margin-left: 0px !important;" v-for="v in revision.sekretaris.catatan" :key="v">
              {{ v }}
            </div>
          </div>
        </div>
        <div class="alert alert-danger" role="alert" v-else style="text-align: center;">
            <i class="fa fa-exclamation-triangle"></i> TIDAK ADA CATATAN REVISI
        </div>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="revlogkassubag">
        <div style="margin-top:10px;"></div>
        <div class="direct-chat-messages" style="height:auto !important;" v-if="revision.kassubag.catatan.length > 0">
          <div class="direct-chat-msg">
            <div class="direct-chat-text" style="margin-left: 0px !important;" v-for="v in revision.kassubag.catatan" :key="v">
              {{ v }}
            </div>
          </div>
        </div>
        <div class="alert alert-danger" role="alert" v-else style="text-align: center;">
            <i class="fa fa-exclamation-triangle"></i> TIDAK ADA CATATAN REVISI
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['revision']
}
</script>
