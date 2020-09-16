<template>
    <div>
        <h1>Student</h1>
        <div class="container">
            <form>
                <div class="form-group">
                    <label for="exampleInputPassword1">Name</label>
                    <input v-model="student.name" type="text" class="form-control" id="exampleInputPassword1" placeholder="Name">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input v-model="student.email"  type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                </div>
                <button type="submit" class="btn btn-primary" @click.prevent="addStudent()">Submit</button>
            </form>
        </div>
        <br>
        <div class="container">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody v-if="students.length">
                <tr v-for="(student,value) in students"  :value= "student.id">
                    <th scope="row">{{student.id}}</th>
                    <td>{{student.name}}</td>
                    <td>{{student.email}}</td>
                    <td>
                            <span>
                                <button type="submit" class="btn btn-danger" @click.prevent="deleteStudent(student.id)">Delete</button>
                                <button type="submit" class="btn btn-success" @click.prevent="editStudent(value)" data-toggle="modal" data-target="#editmodal">Edit</button>
                            </span>
                    </td>
                </tr>
                </tbody>
                <tbody v-else>
                <tr>
                    <td colspan="4">No data available in table</td>
                </tr>
                </tbody>
            </table>
        </div>

        <!--EDIT MODAL START-->
        <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Bank</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col mb-3">
                            <input
                                class="form-control"
                                type="text"
                                name="name"
                                placeholder="Name"
                                v-model="modal.name"
                            />
                        </div>
                        <div class="col">
                            <input
                                class="form-control"
                                type="text"
                                name="email"
                                placeholder="Wmail"
                                v-model="modal.email"
                            />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click.prevent="updateStudent(modal.id)"
                        >Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!--EDIT MODAL END-->
    </div>
</template>

<script>
export default {
    data(){
        return{
            student:{
                name:'',
                email:'',
            },
            modal:{
                name:'',
                email:'',
                id:''
            },
            students:[],
        }
    },
    created() {
        this.getAllStudents();
        var currentDate = new Date();
        console.log(currentDate);
        var currentDateWithFormat = new Date().toJSON().slice(0,10).replace(/-/g,'-');
        console.log(currentDateWithFormat);
    },
    methods:{
        addStudent(){
            let self = this;
            axios.post('api/add-student',
                self.student
            ).then(function (response) {
                self.student.name ='';
                self.student.email ='';
            });

            this.getAllStudents();
        },
        getAllStudents(){
            let self = this;
            axios.get('api/get-all-students')
                .then(function (response) {
                    console.log(response.data);
                    self.students = response.data;
                })
        },
        deleteStudent(id){
            let self = this;
            axios.delete('api/delete-student/'+id)
                .then(function (response) {

                });
            self.getAllStudents();
        },
        editStudent(value){
            let data = this.students[value];
            console.log(data);
            this.modal.id = data.id;
            this.modal.name = data.name;
            this.modal.email = data.email;
            //console.log(this.model.code,"****",this.model.name,this.model.id);
        },
        updateStudent(id){
            let self = this;
            axios.post('api/update-student/'+ id,
                self.modal
            ).then(function (response) {
                location.reload();
            })
            self.getAllStudents();
        },
    }
}
</script>

<style  scoped>

</style>
