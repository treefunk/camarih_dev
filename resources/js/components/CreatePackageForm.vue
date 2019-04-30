<template>
	<div>
		<form  role="form" method="POST" :action="form_url" enctype="multipart/form-data" class="form-horizontal" @submit.prevent="validatePackageForm" >
		<ul class="circle-btns">
			<li :class="{'selected': tab == 1}"  @click="tab = 1"><a>Overview</a></li>
			<li :class="{'selected': tab == 2}" @click="tab = 2"><a>Gallery</a></li>
			<li :class="{'selected': tab == 3}" @click="tab = 3"><a>File Preview</a></li>
		</ul>


		<div v-show="tab == 1" :class="[{'active': tab == 1},'gal-tab']">

			<div class="form-group">
				<label for="is_featured">Featured? </label>
				<input :disabled='package_data.status != "active"' type="checkbox" name="is_featured" v-model="package_.is_featured" :value="package_.is_featured" id="">
				<p style="color:red; font-size: 80%;">NOTE: only 1 featured package is allowed</p>
				<p v-if='package_data.status != "active"' style="color:red; font-size: 80%;">Package must be active</p>
			</div>

			<div class="form-group">
				<label for="main_image">Image</label>
				<div class="full-tab-img" v-if="main_preview != ''">
					<img v-if="main_preview != ''" :src="main_preview" class="preview" alt="">
				</div>
				<input type="file" name="main_image" @change="uploadMainImage" ref="main_image">
			</div>

			<div class="form-group">
	            <label for="name">*Name</label>
	            <input v-model="package_.name" type="text" class="form-control" id="name" placeholder="Enter name" name="name" />
	        </div>


	        <div class="form-group">
	            <label for="rate">*Rate</label>
	            <input v-model="package_.rate" type="text" class="form-control" id="rate" placeholder="Enter rate" name="rate" />
	        </div>

			<div class="form-group">
				
				<label for="">*Minimum Number of Persons</label>
				<div>
					
					<div class="inc-item">
						<input name="minimum_count" v-model="package_.package_details.minimum_count" min="1" type="text" class="form-control"> 
						<div class="btns-hldr">
							<button type="button" @click="package_.package_details.minimum_count++"><i class="fa fa-chevron-up"></i></button>
							<button type="button" @click="package_.package_details.minimum_count--"><i class="fa fa-chevron-down"></i></button>
						</div>
					</div>
				</div>
			</div>

	        <div class="form-group">

	            <label for="description">*Description</label>
					<div id="editor" ref="editor" name="test" v-html="this.package_.package_details.description">
					</div>
	            <!-- <textarea name="description" id="inputdescription" class="form-control" rows="9" v-model="package_data.package_details.description"></textarea> -->
	        </div>

	        <div class="btn-hldr">
	        	<button class="btn_orange right_btn" type="button" @click="tab = 2">Next</button>
	        </div>



		</div>


		<!-- SECOND TAB!! -->
		<div v-show="tab == 2" :class="[{'active': tab == 2},'gal-tab']">
			<div class="form-group">
				<h3>Images</h3>
				

				<div v-for="(uploaded,index) in uploaded_images" :key="index" style="text-align: right;">
					<button class="btn btn-danger" type="button" @click="removeUploaded(index)">X</button>
					<label style="width: 100%; margin-top: 15px; text-align: left;">Title</label>
					<input type="hidden" :name="`uploaded_images[${index}][id]`" :value="uploaded.id">
					<input type="text" class="form-control" v-model="uploaded_images[index].image_title" :name="`uploaded_images[${index}][image_title]`" v-if="uploaded.preview_image != ''" style="margin-top: 0px; margin-bottom: 15px; ">
					<div class="img-holder">
						<img class="preview" :src="`${gallery_url}/${package_.id}_${uploaded.image_name}`" alt="">
					</div>
				</div>

				<div v-for="(gallery,index) in packagegallery" :key="index" style="text-align: right;">
					<button class="btn btn-danger" type="button" @click="remove(index)">X</button>
					<label style="width: 100%; margin-top: 15px; text-align: left;">Title</label>
					<input type="text" class="form-control" v-model="packagegallery[index].image_title" :name="`images[${index}][image_title]`" v-if="gallery.preview_image != ''" style="margin-top: 0px; margin-bottom: 15px; ">
					<div class="img-holder" v-if="gallery.preview_image">
						<img :src="gallery.preview_image" alt="">
					</div>
					<input type="file" @change="loadPreview" :id="`gallery_${index}`" :name="`images[]`" :ref="`gallery_${index}`">
				</div>
				
					<button  type="button" class="btn btn-default" @click="addImage" for="gallery">Add Image</button>
			</div>

	            <div class="btn-hldr">
					<input type="hidden" name="description" :value="package_data.package_details.description">
	            	<button type="button" class="finish btn_green left_btn" @click="tab = 1">Previous</button>
					<button class="btn_orange right_btn" type="button" @click="tab = 3">Next</button>
	            </div>

	            
		</div>

		<!-- third tab -->
		<div v-show="tab == 3" :class="[{'active': tab == 3},'gal-tab']">
					<label for="">Document for Preview</label>
					<div style="font-size:80%">
						Preferred file formats: doc,docx
					</div>
					<div v-if="this.package_.package_download">
						File Name:<p>{{ package_.package_download.file_name }}</p>
						Link:
						<a :href="`${downloads_url}/${package_.package_download.id}_${package_.package_download.file_name}`" :download="package_.package_download.file_name">
							<button class="btn btn-primary" type="button">Download</button>
						</a>
						<p style="color:red; font-size:80%">
							Uploading a new file will overwrite this file.
						</p>
						<iframe :src="`https://docs.google.com/gview?url=${downloads_url}/${package_.package_download.id}_${package_.package_download.file_name}&embedded=true`" frameborder="0"></iframe>
					</div>
				
				<input accept=".doc,.docx" type="file" name="package_download">
			<div class="btn-hldr">
					<input type="hidden" name="description" :value="package_data.package_details.description">
	            	<button type="button" class="finish btn_green left_btn" @click="tab = 2">Previous</button>
					<!-- <button class="btn_orange right_btn" type="button" @click="tab = 3">Next</button> -->
	        </div>
		</div>
		<button type="submit" class="finish btn_orange right_btn">{{ finish_button }}</button>
		</form>
	</div>
</template>

<script>
	
	import package_form_errors from './error_messages/package_form_errors';

	export default {
		mounted(){
			let self = this
			this.editor = CKEDITOR.replace(this.$refs['editor'])
			this.editor.on( 'change', function( evt ) {
				self.package_.package_details.description = evt.editor.getData()
			});
			if(this.package_data.package_image){
				this.main_preview = `${this.main_image_url}/${this.package_data.package_image.id}_${this.package_data.package_image.image_name}`
			}
			this.package_.is_featured = this.package_.is_featured == "1"
		},
		props: {
			form_url: String,
			'uploaded_images_data': {
				type: Array,
				default: () => []
			},
			'packagegallery_data' : {
                type: Array,
                default: () => []
            },
            'gallery_url': {
            	type: String
			},
			'downloads_url': {
				type: String,
				default: ""
			},
			'main_image_url': {
				type: String,
				default: ""
			},
			'package_data' : {
				type: Object,
				default: () => {
					return {
						name:'',
						rate:'',
						package_details:{
							description:'',
							minimum_count:1,
						}
					}
				}
			},
			'finish_button' : {
				type: String,
				default: 'Create'
			},
			'destinations_data': {
				type: Array,
				default: []
			}
		},
		data(){
			return {
				tab: 1,
				main_preview: "",
				packagegallery: this.packagegallery_data,
				package_: this.package_data,
				uploaded_images: this.uploaded_images_data,
				file_list: [],
				enable_preview: true,
				destinations: this.destinations_data,
				editor: "",
				description: ""
			}
		},
		methods: {
			addImage(e){
				
				this.packagegallery.push({
					image_title: "",
					preview_image: ""
				});

				
			},
			deleteUploaded(index){
				this.uploaded_images.splice(index,1)
				
			},
			remove: function(index){
                if(index != this.packagegallery.length - 1){
                    for(var x = index; x < this.packagegallery.length - 1; x++){
                        let f = document.querySelector("input[id='gallery_" + x + "'");
						let next = document.querySelector("input[id='gallery_" + (x+1) + "'");
						let cl = next.cloneNode()
						cl.setAttribute("id","gallery_" + x)
						f.replaceWith(cl);

						this.packagegallery[x].image_title = this.packagegallery[x + 1].image_title
						this.packagegallery[x].preview_image = this.packagegallery[x + 1].preview_image;
						this.packagegallery[x].image_name = this.packagegallery[x + 1].image_name;

                    }
                    this.packagegallery.splice(this.packagegallery.length - 1,1)
                }else{
                    this.packagegallery.splice(index,1)
                }
			},
			loadPreview(){

				
				let preview = "";
				let self = this;
				//iterate all gallery
				for(let x = 0; x < this.packagegallery.length ; x++){
					let reader = new FileReader();
					let elem = document.querySelector(`input[type="file"][id="gallery_${x}"]`).files[0]
					
					if(elem != undefined){
						reader.onload = function(){
							self.packagegallery[x].preview_image = reader.result
						}
						reader.readAsDataURL(elem)
					}
				}
				// update all preview image elem
			},
			uploadMainImage(){
				let reader = new FileReader()
				let elem = this.$refs['main_image'].files[0]
				let self = this

				if(elem != undefined){
					reader.onload = function(){
						self.main_preview = reader.result
					}
				}
				reader.readAsDataURL(elem)
			},
			removeUploaded(index){
				this.uploaded_images.splice(index,1)
			},
			validatePackageForm(e){
				let form = e.target

				let validationScope = Object.keys(package_form_errors);

				let errorBag = {};

				function validateObject(obj)
				{
					for(let key in obj){
						

						if(typeof obj[key] == 'object'){
							validateObject(obj[key])
						}else if(typeof obj[key] != 'boolean'){
							if(!validationScope.includes(key)){
								continue;
							}
							if(obj[key] === ""){
								if(!errorBag.hasOwnProperty(key)){
									errorBag[key] = []
								}
								errorBag[key].push("required");
							}

							if((key == "rate" || key == "minimum_count") && isNaN(obj[key])){
								if(!errorBag.hasOwnProperty(key)){
									errorBag[key] = []
								}
								errorBag[key].push("non_numeric");
							}
						}
					}
				}

				validateObject(this.package_)

				for(let prop in errorBag){
					this.$store.dispatch("showToastr", { message: package_form_errors[prop][errorBag[prop]], type: "error"})
					return -1
				}
				form.submit()
			}
		},
		watch: {
			"package_.package_details.minimum_count": function(newV,oldV){
				if(newV < 1){
					this.$store.dispatch("showToastr",{ type:"error", message: "Minimum count is 1"})
					this.package_.package_details.minimum_count = 1
				}
			}
		}

	}
</script>


<style>
.selected{
	background-color:#f68000 !important;
	/* border: 2px solid black; */
	box-shadow: 2px 2px 1px 1px;
}
</style>
