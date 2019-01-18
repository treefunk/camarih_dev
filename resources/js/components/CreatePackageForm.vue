<template>
	<div>
		<ul class="circle-btns">
			<li :class="{'selected': tab == 1}"  @click="tab = 1"><a>Overview</a></li>
			<li :class="{'selected': tab == 2}" @click="tab = 2"><a>Gallery</a></li>
		</ul>


		<div v-if="tab == 1" :class="{'active': tab == 1}">


			<div class="form-group">
	            <label for="name">Name</label>
	            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" />
	        </div>
	        <div class="form-group">
	            <label for="rate">Rate</label>
	            <input type="text" class="form-control" id="rate" placeholder="Enter rate" name="rate" />
	        </div>

	        <div class="form-group">

	            <label for="description">Description</label>

	            <textarea name="description" id="inputdescription" class="form-control" rows="9"></textarea>
	        </div>

	        <div class="btn-hldr">
	        	<button class="btn_orange right_btn" type="button" @click="tab = 2">Next</button>
	        </div>



		</div>



		<div v-if="tab == 2" :class="{'active': tab == 2}">

				<ul v-if="packagegallery.length > 0">
					<li v-for="(gallery,index) in this.packagegallery" :key="index">
	                    <button class="btn btn-danger">
	                        <i class="fa fa-trash-o"></i>
	                    </button>
	                    <figure>
	                    	<img src=`${this.gallery_url}/${gallery.package_id}_${gallery.image_name}` alt="img04">
	                        <figcaption>                                             
	                        	<input type="hidden" name="images[<?=$index?>][id]" value="<?=$package_image->id?>">
	                            <input type="text" name="images[<?=$index?>][image_title]" id="inputimage_gal_<?=$package_image->id?>"  value="<?=$package_image->image_title?>"  style="color:black">
	                            
	                            
	                            <a class="fancybox" rel="group" href="<?=base_url("uploads/package_gallery/{$package_image->package_id}_{$package_image->image_name}")?>"
	                            title="<?=$package_image->image_title?>"
	                            >View</a>
	                        </figcaption>
	                    
	                                                          	                
	                    </figure>
	                </li>
				</ul>	


				<div class="form-group">
	                <label for="gallery">Add Image/s</label>
	                <input type="file" name="images[]" id="add_images" multiple />
	            </div>

	            <div class="btn-hldr">
	            	<button type="button" class="finish btn_green left_btn" @click="tab = 1">Previous</button>
	            	<button type="submit" class="finish btn_orange right_btn">Create</button>
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
            }
		},
		data(){
			return {
				tab: 1,
				packagegallery: this.packagegallery_data
			}
		}

	}
</script>


<style>
.selected{
	color:green;
}
</style>
