<template>
    
        <div class="col-md-12 card">
            <div class="card-holder">
                <h4 style="text-align: center;">
            Seat {{ passenger.seatnum }}
            </h4>
            <input type="hidden" :name="`selected[${index}][seat_num]`" :value="passenger.seatnum">
            <div class="col-md-12">
            <div class="form-group">
                <label for="guest1">
                Passenger's Name
                </label>
                <div class="input-group">

                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-user"></span>
                    </span>
                <input :name="`selected[${index}][name]`" :placeholder="`Seat ${passenger.seatnum} Fullname`" id="guest1" class="form-control" type="text" required="">
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
                       <input :name="`selected[${index}][bday]`" type="date" id="bdate1" value="2001-01-10" max="2019-01-10" class="form-control" required="">
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
            index: Number
        },
        methods: {
            updateSelected(e){
                    let passenger = {
                        seatnum: this.passenger.seatnum,
                        name: e.target.value
                    }
                    this.$emit('update-passenger-name',passenger)
            }
        }
    }
</script>

<style scoped>

</style>