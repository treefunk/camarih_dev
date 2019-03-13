<template>
	<div>
		<ul class="circle-btns">
			<li :class="{'selected': tab == 1}"  @click="tab = 1"><a>Overview</a></li>
			<li :class="{'selected': tab == 2}" @click="tab = 2"><a>Gallery</a></li>
		</ul>


		<div v-show="tab == 1" :class="{'active': tab == 1}">


			<div class="form-group">
	            <label for="name">Name</label>
	            <input v-model="package_data.name" type="text" class="form-control" id="name" placeholder="Enter name" name="name" />
	        </div>


	        <div class="form-group">
	            <label for="rate">Rate</label>
	            <input v-model="package_data.rate" type="text" class="form-control" id="rate" placeholder="Enter rate" name="rate" />
	        </div>

			<div class="form-group">
				
				<label for="">Minimum Number of Persons</label>
				<div>
					<input name="minimum_count" v-model="package_data.package_details.minimum_count" min="0" type="number" class="form-control"> 
				</div>
			</div>

	        <div class="form-group">

	            <label for="description">Description</label>

	            <textarea name="description" id="inputdescription" class="form-control" rows="9" v-model="package_data.package_details.description"></textarea>
	        </div>

	        <div class="btn-hldr">
	        	<button class="btn_orange right_btn" type="button" @click="tab = 2">Next</button>
	        </div>



		</div>



		<div v-show="tab == 2" :class="{'active': tab == 2}">

				<ul v-if="packagegallery.length > 0">
					<li v-for="(gallery,index) in this.packagegallery" :key="index">
						<button class="btn btn-danger" type="button" @click="removeImage(index,gallery.id)">
							<i class="fa fa-trash-o"></i>
						</button>
						<figure>

							<img :src="`${gallery_url}${gallery.package_id}_${gallery.image_name}`" alt="img04">
							<figcaption> <input type="hidden" :name="`images[${index}][id]`" :value="gallery.id">
								<input type="text" :name="`images[${index}][image_title]`" :id="`inputimage_gal_${gallery.id}`" :value="gallery.image_title"
								style="color:black">


								<a class="fancybox" rel="group" :href="`${gallery_url}${gallery.package_id}_${gallery.image_name}`"
								:title="gallery.image_title">View</a>
							</figcaption>
						</figure>
					</li>
				</ul>	


				<div class="form-group">
	                <label for="gallery">Add Image/s</label>
	                <input @change="uploadIm" type="file" name="images[]" id="add_images" multiple />
	            </div>

				<div v-if="enable_preview">
					<ul>
						<li v-for="(uploaded,index) in uploaded_images" :key="index">
							<button type="button" class="btn btn-danger" @click="deleteUploaded(index)">X</button>
							<div>
								<img :src="uploaded.preview_image" alt="">
								<input type="text" name="" id="">
							</div>

						</li>
					</ul>
				</div>

	            <div class="btn-hldr">
	            	<button type="button" class="finish btn_green left_btn" @click="tab = 1">Previous</button>
	            	<button type="submit" class="finish btn_orange right_btn">{{ finish_button }}</button>
	            </div>
	            
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			'packagegallery_data' : {
                type: Array,
                default: () => []
            },
            'gallery_url': {
            	type: String
            },
			'package_data' : {
				type: Object,
				default: () => {
					return {
						name:'',
						rate:'',
						package_details:{
							description:'',
							minimum_count:0,
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
		methods: {
			uploadIm(e){
				let uploadElem = e.target
				let files = uploadElem.files
				this.file_list = files
				let that = this

				for(let x = 0 ; x < files.length; x++){
					var reader = new FileReader();

					reader.onload = function(e) {
						let prev_image = e.target.result
						let preview = {
							preview_image: prev_image,
							title: ''
						}
						console.log({
							counter: x,
							preview: preview
						})
						that.uploaded_images.push(preview);
					}

					
				reader.readAsDataURL(files[x]);
				}

				
			},
			deleteUploaded(index){
				this.uploaded_images.splice(index,1)
				console.log(this.uploaded_images);
				// delete this.file_list[index]
				// console.log(this.file_list)
				
			},
			removeImage(index,image_id){
				this.packagegallery_data.splice(index,1)
				//TODO: RUN AJAX HERE TO REMOVE IMAGE IN DB
				console.log(`deleting ${image_id}... in db`)
			}
		},
		data(){
			return {
				tab: 1,
				packagegallery: this.packagegallery_data,
				package: this.package_data,
				uploaded_images: [],
				file_list: [],
				enable_preview: true,
				destinations: this.destinations_data
			}
		}

	}
</script>


<style>
.selected{
	color:green;
}
</style>
