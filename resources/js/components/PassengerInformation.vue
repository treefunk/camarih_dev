<template>
    
        <div class="col-md-12 card" v-if="passenger.selected && !passenger.isPending">
            <!-- <button class="btn btn-danger" type="button" >dfsfsdfsdfsdfsX</button> -->
            <div class="card-holder">
                <div class="pull-right" style="z-index:1039">
                    <button type="button" class="btn btn-danger" @click="unselect(index,parentindex)">
                        <i  class="fa fa-times fa-lg"></i>
                    </button>
                </div>
                <h4 style="text-align: center;">
            Seat {{ passenger.seatnum }}
            </h4>
            <input type="hidden" :name="`selected[${passenger.seatnum}][seatnum]`" :value="passenger.seatnum">
            <div class="col-md-12">
            <div class="form-group">
                <label for="guest1">
                Passenger's Name
                </label>
                <div class="input-group">

                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-user"></span>
                    </span>
                <input v-model="passenger.name" :name="`selected[${passenger.seatnum}][name]`" :placeholder="`Seat ${passenger.seatnum} Fullname`" id="guest1" class="form-control" type="text" required="">
                </div>

            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
              <label for="bdate1">
                Birthdate
                </label>
                <div class="input-group date">

                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                       <input :name="`selected[${passenger.seatnum}][bday]`" type="date" id="bdate1" value="2001-01-10" max="2019-01-10" class="form-control" required="">
                </div>
            </div>

            </div>
            </div>



        </div>
    
</template>

<script>
    export default {
        props: {
            passenger: Object,
            index: Number,
            parentindex: Number,
        },
        methods: {
            updateSelected(e){
                    let passenger = {
                        seatnum: this.passenger.seatnum,
                        name: e.target.value
                    }
                    this.$emit('update-passenger-name',passenger)
            },  
            unselect(idx,parentindex){
                this.$emit('unselectSeat', { index: idx, parentindex: parentindex })
            }
        }
    }
</script>

<style scoped>

</style>