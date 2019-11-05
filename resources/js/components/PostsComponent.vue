<template>
    <div class="container-fluid">
        <div class="card mb-2">
            <div class="card-header text-center">Tweet Your Thoughts
            </div>
            <form @submit.prevent="addPost">
                <div class="form-group">
                    <textarea type="text" class="form-control" placeholder="Tweet Here" v-model="post.post"></textarea>
                    <button type="submit" class="btn btn-light btn-block">Tweet</button>
                </div>
            </form>
        </div>
        <div class="row justify-content-center">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchPosts(pagination.prev_page_url)">Previous</a></li>

                    <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>

                    <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchPosts(pagination.next_page_url)">Next</a></li>
                </ul>
            </nav>
        
            <div v-for="post in posts" v-bind:key="post.id" class="card mb-2 col-12">

                <div class="card-body">
                    <h4>{{post.post}}</h4>
                    <h6 class="font-color-blue" v-if="!post.edit">{{post.author}}</h6>
                    <textarea class="col-12" v-model="post.post" v-if="post.edit" cols="30" rows="3"></textarea>

                    <!-- Delete Button -->
                    <button v-if="!post.edit && isCurrentUser(post.author_id)" @click="deletePost(post.id)" class="btn btn-danger btn-sm col-2">Delete</button>

                    <!-- Edit Button -->
                    <button v-if="!post.edit && isCurrentUser(post.author_id)" @click="post.edit = !post.edit" class="btn btn-warning btn-sm col-2">Edit</button>

                    <!-- Update Button -->
                    <button v-if="post.edit && isCurrentUser(post.author_id)" @click="post.edit = !post.edit" class="btn btn-primary btn-sm col-2">Update</button>

                    <!-- Cancel Button -->

                    <button v-if="post.edit && isCurrentUser(post.author_id)" @click="post.edit = !post.edit" class="btn btn-warning btn-sm col-2">Cancel</button>
                </div>
                
            </div>
            
        </div>
    </div>
</template>

<script>
import { makeRe } from 'minimatch';
    export default {
       data() {
           return{
               posts: [],
               post: {
                   id: '',
                   post: '',
                   author:'',
                   edit: false
               },
               post_id: '',
               pagination:{},

           }
       },

       created() {
           this.fetchPosts();
       },

        methods: {
            fetchPosts(page_url){
                let vm = this;
                page_url = page_url || '/api/posts';
                fetch(page_url)
                    .then(res=>res.json())
                    .then(res => {
                        this.posts = res.data;
                        vm.makePagination(res.meta, res.links);
                    })
                    .catch(err=> console.log(err));
            },
            makePagination(meta, links){
                let pagination = {
                    current_page : meta.current_page,
                    last_page : meta.last_page,
                    next_page_url : links.next,
                    prev_page_url : links.prev
                }
                this.pagination = pagination;
            },
            deletePost(id){
                if (confirm('Are You Sure?')) {
                    fetch(`api/post/${id}`, {
                        method: 'delete',
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector("[name~=csrf-token][content]").content
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert('Post Removed');
                        this.fetchPosts();

                    })
                    .catch(err=> console.log(err));
                }

            },
            addPost(){
                if (this.post.edit === false) {
                    //add
                    
                    this.post._token= document.head.querySelector("[name~=csrf-token][content]").content;
                    console.log();
                    fetch('api/post', {
                        method: 'post',
                        body: JSON.stringify(this.post),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.post.post = '';
                        this.post.author = '';
                        this.fetchPosts();

                    })
                    .catch(err=> console.log(err));
                    
                }else{
                    //Update
                }
            },
            isCurrentUser(id){
                const userId = document.head.querySelector("[name~=user-id][content]").content;
                if (userId == id) {
                    return true 
                    
                }
                return false

            }
        },
    }
</script>
