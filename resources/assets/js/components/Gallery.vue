<template>
    <dropzone
        id="myVueDropzone"
        url="api/galleries"
        ref="dropzone"
        :headers="csrfHeader"
        :maxFiles=maxFiles
        :resizeQuality=resizeQuality
        :maxFileSizeInMB=maxFileSize
        :dictResponseError=StatusCode
        v-on:vdropzone-success="showSuccess"
        v-bind:preview-template="template"
        v-on:vdropzone-removed-file="deleteFile">
    </dropzone>
</template>

<script>
  import Dropzone from 'vue2-dropzone'

  export default {
    mounted () {
        this.$refs.dropzone.dropzone.on('error', function (file, response) {
            $(file.previewElement).find('.dz-error-message').text(response.message[0])
        })
    },
    props : {
        maxFiles: {type : Number, default : 100},
        resizeQuality: {type : Number, default : 1.0},
        maxFileSize: {type : Number, default : 10},
        StatusCode: {type : Number, default : 400},
    },
    name: 'Gallery',
    data() {
        return {
            model: {
                data: []
            },
            csrfToken: document.head.querySelector('meta[name="csrf-token"]').content,
            csrfHeader: {
                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
            }
        }
    },
    beforeMount() {
        this.fetchData()
    },
    components: {
      Dropzone
    },
    methods: {
       'template' : function() {
          return `
                 <div class="dz-preview dz-file-preview">
                 <div class="dz-image" style="width: 200px;height: 200px">
                 <img data-dz-thumbnail /></div>
                 <div class="dz-details">
                 <div class="dz-size"><span data-dz-size></span></div>
                 <div class="dz-filename"><span data-dz-name></span></div>
                 </div>
                 <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                 <div class="dz-error-message"><span data-dz-errormessage></span></div>
                 <div class="dz-success-mark"><i class="fa fa-check"></i></div>
                 <div class="dz-error-mark"><i class="fa fa-close"></i></div>
                 </div>
                  `;
      },
      'showSuccess': function (file, response) {
        file.id = response.response[0].id
      },
      'deleteFile' : function (file, error, xhr) {
        console.log(file);
        axios.delete('api/galleries/'+file.id).then((response) => {
           console.log(response)
        }).catch((error) => {
           console.log(error)
        })
      },
      'fetchData' : function () {
        axios.get('api/galleries').then((response) => {
            var galleries = response.data.response
            for (var i = 0; i < galleries.length; i++) {
               var image = {
                  id: galleries[i].id,
                  name: galleries[i].name,
                  size: galleries[i].size
                };

                var fileUrl = '/assets/image/'+galleries[i].name+'.'+galleries[i].mimes;
                console.log(image)
                this.$refs.dropzone.manuallyAddFile(image, fileUrl, null, null, {dontSubstractMaxFiles: true, addToFiles: true});
            }
        }).catch((error) => {
            console.log(error)
        })
      }
    }
  }
</script>

<style>

    .vue-dropzone {
        .dz-preview {
            .dz-image {
                border-radius: 1;
                &:hover {
                    img {
                        transform: none;
                        -webkit-filter: none;
                    }
                }
            }
            .dz-details {
                bottom: 0;
                top: 0;
                color: white;
                background-color: rgba(33, 150, 243, 0.8);
                transition: opacity .2s linear;
                text-align: left;
                .dz-filename span, .dz-size span {
                    background-color: transparent;
                }
                .dz-filename:not(:hover) span {
                    border: none;
                }
                .dz-filename:hover span {
                    background-color: transparent;
                    border: none;
                }
            }
            .dz-progress .dz-upload {
                background: #cccccc;
            }
            .dz-remove {
                position: absolute;
                z-index: 30;
                color: white;
                margin-left: 15px;
                padding: 10px;
                top: inherit;
                bottom: 15px;
                border: 2px white solid;
                text-decoration: none;
                text-transform: uppercase;
                font-size: 0.8rem;
                font-weight: 800;
                letter-spacing: 1.1px;
                opacity: 0;
            }
            &:hover {
                .dz-remove {
                    opacity: 1;
                }
            }
            .dz-success-mark, .dz-error-mark {
                margin-left: auto !important;
                margin-top: auto !important;
                width: 100% !important;
                top: 35% !important;
                left: 0;
                i {
                    color: white !important;
                    font-size: 5rem !important;
                }
            }
        }
    }
</style>

