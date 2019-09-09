<template>
	<div>
		<form  role="form" method="POST" :action="form_url" enctype="multipart/form-data" class="form-horizontal" @submit.prevent="validatePackageForm" >
		<ul class="circle-btns">
			<li :class="{'selected': tab == 1}"  @click="tab = 1"><a>Overview</a></li>
			<li :class="{'selected': tab == 2}" @click="tab = 2"><a>Gallery</a></li>
			<li :class="{'selected': tab == 3}" @click="tab = 3"><a>Itinerary</a></li>
			<li :class="{'selected': tab == 4}" @click="tab = 4"><a>Tour <br>Details</a></li>
			<li :class="{'selected': tab == 5}" @click="tab = 5"><a>File Preview</a></li>
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
	            <input v-model="package_.name" type="text" class="form-control" placeholder="Enter name" name="name" />
	        </div>

	        <div class="form-group">
	            <label for="name">*Location</label>
	            <p style="margin-left: 9px; ">Tip: Hold down the Ctrl (windows) / Command (Mac) button to select multiple options.</p>
	            <select class="form-control" v-model="package_.package_locations" name="destination_id[]" multiple>
                    <option value="">Select Destination</option>
                    <option v-for="destination in destinations" :key="destination.id" :value="destination.id">{{ destination.name }}</option>
                </select>
	        </div>


	        <div class="form-group">
                <label for="select_type">*Select Tour Type</label>
                <div class="radio">
                        <label>
                            <input type="radio" v-model="package_.is_day_tour" name="is_day_tour" value="1">
                            Day Tour
                        </label>
                        <label>
                            <input type="radio" v-model="package_.is_day_tour" name="is_day_tour" value="0">
                            Package Tour
                        </label>
                </div>
            </div>

            <div class="form-group" v-if="package_.is_day_tour == 0">
	            <label for="name">Tour Package</label>
	            <select class="form-control" name="" v-model="package_.package_root_name">
                    <option v-for="package_tour in rootpackages" :value="package_tour" >{{ package_tour.name }} ({{package_tour.duration_format}})</option>
                </select>
                <input type="hidden" name="package_tour_id" v-model="package_.package_root_id">
	        </div>
	         <div class="form-group" v-if="package_.is_day_tour == 0 && package_.package_root_name.sub_directories">
	            <label for="name">Tour Package Sub</label>
	            <select class="form-control" name="sub_packages" v-model="package_.package_tour_id">
                    <option v-for="package_tour in package_.package_root_name.sub_directories" :value="package_tour.id">{{ package_tour.name }}</option>
                </select>
	        </div>

	        <div class="form-group">
	            <label for="rate">*Rate</label>
	            <input v-model="package_.rate" type="text" class="form-control" id="rate" placeholder="Enter rate" name="rate" />
	        </div>

			<div class="form-group">
				<label for="">*Minimum Number of Persons</label>
				<div>
					
					<div class="inc-item">
						<input name="minimum_count" v-model="package_.minimum_count" min="1" type="text" class="form-control"> 
						<div class="btns-hldr">
							<button type="button" @click="package_.minimum_count++"><i class="fa fa-chevron-up"></i></button>
							<button type="button" @click="package_.minimum_count--"><i class="fa fa-chevron-down"></i></button>
						</div>
					</div>
				</div>
			</div>

			
                <input type="hidden" name="" v-model="package_.package_tour_id">

	        <div class="form-group">

	            <label for="description">Description</label>
	            	<ckeditor id="editor" :editor="ckeditor" :config="editorConfig" v-model="package_.package_details.description"></ckeditor>
	        </div>

	        <div class="form-group">

	            <label for="description">Price Description</label>
	            	<ckeditor id="editor" :editor="ckeditor" :config="editorConfig" v-model="package_.package_details.price_description"></ckeditor>
	        </div>

	        <div class="btn-hldr">
	        	<input type="hidden" name="description" :value="package_data.package_details.description">
	        	<input type="hidden" name="price_description" :value="package_data.package_details.price_description">
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
					
	            	<button type="button" class="finish btn_green left_btn" @click="tab = 1">Previous</button>
					<button class="btn_orange right_btn" type="button" @click="tab = 3">Next</button>
	            </div>

	            
		</div>


		<!-- 3rd TAB!! -->
		<div v-show="tab == 3" :class="[{'active': tab == 3},'gal-tab']">
			<div class="form-group">
				<h3>Itinerary</h3>

				<div v-for="(itinerary,index) in package_.package_itineraries" :key="index" style="text-align: right;">
					<button class="btn btn-danger" type="button" @click="removeItinerary(index)">X</button>
					<input type="hidden" :name="`itineraries[${index}][id]`" v-model="package_.package_itineraries[index].id">
					<label style="width: 100%; margin-top: 15px; text-align: left;">Title</label>
					<input type="text" class="form-control" :id="`itineraries[${index}][title]`" :name="`itineraries[${index}][title]`" v-model="package_.package_itineraries[index].title">

					<label style="width: 100%; margin-top: 15px; text-align: left;">Time</label>
					<input type="text" class="form-control" :id="`itineraries[${index}][time]`" :name="`itineraries[${index}][time]`" v-model="package_.package_itineraries[index].time">
					<div class="form-group">
						<label style="width: 100%; margin-top: 15px; text-align: left;">Description</label>
							<ckeditor :id="`editor_itineraries_${index}`" :ref="`editor_itineraries_${index}`" :name="`itineraries[${index}][description]`"  :editor="ckeditor" :config="editorConfig" v-model="package_.package_itineraries[index].description"></ckeditor>
			        </div>
					<input type="hidden" :id="`itineraries[${index}][description]`" :name="`itineraries[${index}][description]`" :value="package_.package_itineraries[index].description">
					<hr>
				</div>
				<button  type="button" class="btn btn-default" @click="addItinerary" for="itinerary">Add Itinerary</button>
			</div>

	            <div class="btn-hldr">
	            	<button type="button" class="finish btn_green left_btn" @click="tab = 2">Previous</button>
					<button class="btn_orange right_btn" type="button" @click="tab = 4">Next</button>
	            </div>

	            
		</div>

		<div v-show="tab == 4" :class="[{'active': tab == 4},'gal-tab']">
			
	        <div class="form-group">

	            <h3>Inclusions</h3>
	            	<ckeditor :editor="ckeditor" :config="editorConfig" v-model="package_.package_details.inclusions" v-html="this.package_.package_details.inclusions"></ckeditor>
	        </div>
	        <hr>
	        <div class="form-group">

	            <h3>Exclusions</h3>
	            	<ckeditor :editor="ckeditor" :config="editorConfig" v-model="package_.package_details.exclusions"></ckeditor>
	        </div>
	        <hr>
	        <div class="form-group">

	            <h3>Booking Conditions</h3>
	            	<ckeditor :editor="ckeditor" :config="editorConfig" v-model="package_.package_details.booking_conditions"></ckeditor>
	        </div>
	        <hr>
	        <div class="form-group">
				<h3>Accomodations</h3>	
				<div v-for="(itinerary,index) in package_.package_accomodations" :key="index" style="text-align: right;">
					<button class="btn btn-danger" type="button" @click="removeAccom(index)">X</button>
					<input type="hidden" :name="`accom[${index}][id]`" v-model="package_.package_accomodations[index].id">
					<label style="width: 100%; margin-top: 15px; text-align: left;">Title</label>
					<input type="text" class="form-control" :id="`accom[${index}][title]`" :name="`accom[${index}][title]`" v-model="package_.package_accomodations[index].title">
					<div class="form-group">
						<label style="width: 100%; margin-top: 15px; text-align: left;">Description</label>
							<ckeditor :id="`editor_accom_${index}`" :ref="`editor_accom_${index}`" :name="`accom[${index}][description]`"  :editor="ckeditor" :config="editorConfig" v-model="package_.package_accomodations[index].description"></ckeditor>
			        </div>
					<input type="hidden" :id="`accom[${index}][description]`" :name="`accom[${index}][description]`" :value="package_.package_accomodations[index].description">
					<hr>
				</div>
				<button  type="button" class="btn btn-default" @click="addAccom" for="itinerary">Add Accomodation</button>
			</div>
	        <div class="btn-hldr">
	        	<input type="hidden" name="inclusions" :value="package_data.package_details.inclusions">
	        	<input type="hidden" name="exclusions" :value="package_data.package_details.exclusions">
	        	<input type="hidden" name="booking_conditions" :value="package_data.package_details.booking_conditions">
	        	<button class="btn_orange right_btn" type="button" @click="tab = 5">Next</button>
	        </div>



		</div>
		<!-- 4th tab -->
		<div v-show="tab == 5" :class="[{'active': tab == 5},'gal-tab']">
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
	            	<button type="button" class="finish btn_green left_btn" @click="tab = 4">Previous</button>
	        </div>
		</div>
		<button type="submit" class="finish btn_orange right_btn">{{ finish_button }}</button>
		</form>
	</div>
</template>

<script>
	
	import package_form_errors from './error_messages/package_form_errors';
	import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

	export default {
		mounted(){

			let self = this
			if(this.package_data.package_image){
				this.main_preview = `${this.main_image_url}/${this.package_data.package_image.id}_${this.package_data.package_image.image_name}`
			}
			this.package_.is_featured = this.package_.is_featured == "1"

			if (this.package_.package_root_name) {
				for (var i = 0; i <= this.rootpackages.length - 1; i++) {
					if (this.package_.package_root_name.is_sub_directory_format == this.rootpackages[i].name) {
						this.package_.package_root_name = this.rootpackages[i];
					}
				}
			}

			if (this.package_.is_day_tour == 1) {
				this.package_.package_category = 'daytour';
			}
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
						destination_id:'',
						is_day_tour:1,
						package_locations:[],
						rate:'',
						package_details:{
							description:'',
							exclusions:'',
							inclusions:'',
							booking_conditions:'',
						},
						minimum_count:1,
						package_tour_id:'',
						package_root_id:'',
						package_itineraries:[],
						package_accomodations:[],
						package_root_name:[],
						package_category:'',
						location_name:'',
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
			},
			'root_packages_tour_labels': {
				type: Array,
				default: []
			}
		},
		data(){
			return {
				tab: 1,
				main_preview: "",
				packagegallery: this.packagegallery_data,
				num_itinerary: 0,
				package_: this.package_data,
				uploaded_images: this.uploaded_images_data,
				file_list: [],
				enable_preview: true,
				destinations: this.destinations_data,
				rootpackages: this.root_packages_tour_labels,
				subpackages: [],
				editor: "",
				description: "",
				selectedrootpackages : "",				
				selectedrootpackages_val : "",	
				ckeditor: ClassicEditor,
                editorConfig: {
			        removePlugins: [ 'Heading', 'Link', 'blockQuote'],
			        toolbar: [ 'bold', 'italic', 'bulletedList', 'numberedList']
			    },

			}
		},
		methods: {
			addImage(e){
				this.packagegallery.push({
					image_title: "",
					preview_image: ""
				});

				
			},
			addItinerary(e){
				this.package_.package_itineraries.push({
					title: "",
					time:"",
					description:""
				});
				
			},
			addAccom(e){
				this.package_.package_accomodations.push({
					title: "",
					description:""
				});
				
			},
			deleteUploaded(index){
				this.uploaded_images.splice(index,1)
				
			},
			removeAccom: function(index) {
				this.package_.package_accomodations.splice(index,1)
			},
			removeItinerary: function(index) {

				function arrayRemove(arr, value) {

				   return arr.filter(function(ele){
				       return ele != value;
				   });

				}
				this.package_.package_itineraries.splice(index,1)
				// this.package_.package_itineraries = arrayRemove(this.package_.package_itineraries, this.package_.package_itineraries[index]);
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

						if(key == "package_itineraries"){
								continue
						}
						
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
			"package_.minimum_count": function(newV,oldV){
				if(newV < 1){
					this.$store.dispatch("showToastr",{ type:"error", message: "Minimum count is 1"})
					this.package_.minimum_count = 1
				}
			},
			"package_.package_root_name" : function(newV,oldV){
				// this.subpackages = newV.sub_directories;
				this.package_.package_root_name.sub_directories = newV.sub_directories;
				this.package_.package_root_id = newV.id;
				if (newV.sub_directories[0]) {
					this.package_.package_tour_id = newV.sub_directories[0].id;
				}

			},
			"package_.is_day_tour" : function(newV,oldV){
				if (newV == 1) {
					this.package_.package_category = 'daytour';
				}else{
					this.package_.package_category = this.package_.package_root_name;
					this.package_.package_root_name = this.rootpackages[0];
				}

			},

			"package_.package_locations" : function(newV,oldV){
				this.package_.location_name=newV[0];

			},


		}

	}
</script>


<style>
	.selected{
		background-color:#f68000 !important;
		/* border: 2px solid black; */
		box-shadow: 2px 2px 1px 1px;
	}
    div.ck .ck-editor__main ul li {
        list-style: disc;
        margin-left: 55px;
        text-align: left;
    }
    div.ck .ck-editor__main ol li {
        text-align: left;
    }
    div.ck .ck-editor__main p{
        text-align: left;
    }
    .ck-editor__editable_inline { min-height: 200px;max-height: 200px; } 
</style>
