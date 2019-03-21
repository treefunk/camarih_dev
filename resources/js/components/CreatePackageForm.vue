<template>
	<div>
		<form  role="form" method="POST" :action="form_url" enctype="multipart/form-data" class="form-horizontal" >
		<ul class="circle-btns">
			<li :class="{'selected': tab == 1}"  @click="tab = 1"><a>Overview</a></li>
			<li :class="{'selected': tab == 2}" @click="tab = 2"><a>Gallery</a></li>
			<li :class="{'selected': tab == 3}" @click="tab = 3"><a>Inclusions</a></li>
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


		<!-- SECOND TAB!! -->
		<div v-show="tab == 2" :class="{'active': tab == 2}">

				<div v-for="(uploaded,index) in uploaded_images" :key="index">
					<button class="btn btn-danger" type="button" @click="removeUploaded(index)">X</button>
					<input type="hidden" :name="`uploaded_images[${index}][id]`" :value="uploaded.id">
					<input type="text" class="form-control" v-model="uploaded_images[index].image_title" :name="`uploaded_images[${index}][image_title]`" v-if="uploaded.preview_image != ''">
					<img class="preview" :src="`${gallery_url}/${package_.id}_${uploaded.image_name}`" alt="">
				</div>

				<div v-for="(gallery,index) in packagegallery" :key="index">
					<button class="btn btn-danger" type="button" @click="remove(index)">X</button>
					<input type="text" class="form-control" v-model="packagegallery[index].image_title" :name="`images[${index}][image_title]`" v-if="gallery.preview_image != ''">
					<img :src="gallery.preview_image" alt="">
					<input type="file" @change="loadPreview" :id="`gallery_${index}`" :name="`images[]`" :ref="`gallery_${index}`">
				</div>
				
					<button  type="button" class="btn btn-default" @click="addImage" for="gallery">Add Image</button>


	            <div class="btn-hldr">
	            	<button type="button" class="finish btn_green left_btn" @click="tab = 1">Previous</button>
	            	<button type="submit" class="finish btn_orange right_btn">{{ finish_button }}</button>
	            </div>
	            
		</div>

		<!-- third tab -->
		<div v-show="tab == 3" :class="{'active': tab == 3}">
			inclusions
		</div>
		</form>
	</div>
</template>

<script>
	export default {
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
		data(){
			return {
				tab: 1,
				packagegallery: this.packagegallery_data,
				package_: this.package_data,
				uploaded_images: this.uploaded_images_data,
				file_list: [],
				enable_preview: true,
				destinations: this.destinations_data
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
						console.log(next)
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
						console.log(elem)
						reader.readAsDataURL(elem)
					}
				}
				// update all preview image elem
			},
			removeUploaded(index){
				this.uploaded_images.splice(index,1)
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
