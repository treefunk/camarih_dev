<template>
    <form :action="ajax_url" method="post" @submit.prevent="sendContact" class="" >
            <h3>Contact us</h3>
            <div id="contactMessage" class="contact-message">
                {{ notif }}
            </div>
            <div :class="['form-group',{ 'has-error': error.name }]">
                <input class="form-control" v-model="name" type="text" id="name" name="name" placeholder="Name"><i class="form-control-feedback" aria-hidden="true"></i></div>
            <div :class="['form-group',{ 'has-error': error.email }]">
                <input class="form-control" v-model="email" type="email" id="email" name="email" placeholder="Email"><i class="form-control-feedback" aria-hidden="true"></i>
            </div>
            <div :class="['form-group',{ 'has-error': error.phone }]">
                <input type="text" name="phone" v-model="phone" id="phone" placeholder="Phone" class="form-control"><i class="form-control-feedback" aria-hidden="true"></i></div>
            <div :class="['form-group',{ 'has-error': error.message }]">
                <textarea class="form-control" v-model="message" id="message" rows="12" name="message" placeholder="Message" style="margin-top: 0px; margin-bottom: 0px; height: 100px;"></textarea>
            </div>
            
            <div class="col-md-offset-4" style="margin-bottom:10px; margin-top:10px;">
                <div class="g-recaptcha" :data-sitekey="site_key"></div>
            </div>

            <div class="form-group text-center">
                 <button class="btn btn-default" type="submit" :disabled="disableSend">Send</button>
            </div>
            
        </form>
</template>

<script>

    export default {
        props: {
            site_key: {
                type: String,
            },
            ajax_url: {
                type: String
            }
        },
        data(){
            return {
                name: "",
                email: "",
                phone: "",
                message: "",
                notif: "",
                disableSend: false,
                error: {
                    name: false,
                    email: false,
                    phone: false,
                    message: false
                }
            }
        },
        methods: {
            sendContact(){
                let self = this
                self.notif = ""
                self.disableSend = true

                for(let k in self.error){
                    self.error[k] = false
                }

                let data = {
                    name: self.name,
                    email: self.email,
                    phone: self.phone,
                    message: self.message
                };

                for(let ki in self.error){
                    if(data[ki].trim() == ""){
                        self.error[ki] = true
                    }
                }
                

                for(let key in data){
                    if(data[key].trim() == ""){
                        self.$store.dispatch("showToastr",{ type:"error", message: `Please enter your ${key}.`});
                        self.disableSend = false
                        return -1;
                    }
                }

                if(grecaptcha.getResponse().trim() == ""){
                    console.log(grecaptcha)
                   self.disableSend = false
                   self.$store.dispatch("showToastr",{ type:"error", message: `Please verify that you're not a robot.`});
                    return -1;
                }

                $.post(self.ajax_url,data).done(function(res){

                    self.disableSend = false
                    res = JSON.parse(res)
                    if(res.status == 'success'){

                        self.notif = res.message;

                        self.name = ""
                        self.email = ""
                        self.phone = ""
                        self.message = ""

                    }else{
                        self.$store.dispatch("showToastr",{ type:"error", message: res.message});
                    }
                    grecaptcha.reset();
                })
            }
        }
    }
</script>

<style scoped>

</style>