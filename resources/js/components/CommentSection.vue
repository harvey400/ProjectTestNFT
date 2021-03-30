<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card border border-primary">
                    <div class="card-body">
                        <div class=" mb-2">
                            <div class="post rounded p-4">Hello World!</div>
                        </div>
                        <input v-model="commentBody" v-on:keypress="postComment($event)" type="text" placeholder="Write a comment..." class="mb-2 form-control bg-gray comment-input">
                        <!-- Comments -->
                        <div class="pt-2" v-for="comment in comments" :key="comment.id"  >
                            <div class="pl-3 pr-5 pb-1 pt-2 comment d-inline-block">
                                <div class="font-weight-bold">{{comment.name}}</div> 
                                <div>{{comment.body}}</div>
                            </div>
                            <div><span class="pl-4 reply-button" v-on:click="comment.showReply = !comment.showReply, $forceUpdate()">Reply</span> • {{parseDate(comment.created_at)}}</div>
                            <!-- Reply -->
                            <div class="pl-5" v-for="reply in comment.replies" :key="reply.id">
                                <div class="mb-1 pl-3 pr-5 pt-2 comment d-inline-block">
                                    <div class="font-weight-bold">{{reply.name}}</div>
                                    <div>{{reply.body}}</div>
                                </div>
                                <div><span class="pl-4 reply-button" v-on:click="reply.showReply = !reply.showReply, $forceUpdate()">Reply</span> • {{parseDate(reply.created_at)}}</div>
                                <!-- Replies 2 -->
                                <div class="pl-5" v-for="reply2 in reply.replies2" :key="reply2.id">
                                    <div class="mb-1 pl-3 pr-5 pt-2 comment d-inline-block">
                                        <div class="font-weight-bold">{{reply2.name}}</div>
                                        <div>{{reply2.body}}</div>
                                    </div>
                                     <div class="pl-3">{{parseDate(reply2.created_at)}}</div>
                                </div>
                                <div class="pl-5">
                                    <input v-if="reply.showReply" v-model="reply.reply"  v-on:keypress="postReply($event,reply)" :comment-data="reply.id"  type="text" placeholder="Write a comment..." class="commentBox mb-1 form-control bg-gray comment-input">
                                </div>
                            </div>
                            <div class="pl-5">
                             <input v-if="comment.showReply" v-model="comment.reply"  v-on:keypress="postReply($event,comment)" type="text" placeholder="Write a comment..." class="commentBox mb-1 form-control bg-gray comment-input">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                comments:[],
                user:{"user_id":2,"name":"Harvey"},
                commentBody:"",
                replyInputShow1:false,
            }
        },
        methods:{
            parseDate(date){
                var d = new Date(date);
                var year = d.getFullYear();
                var month = d.getMonth();
                var day = d.getDate();
                var hours = d.getHours();
                var minutes = d.getMinutes();
                return year + "-" + month +  "-" + day + " " + hours + ":" + minutes;
            },
            postReply(event,data){
                
                if(event.keyCode==13){
                    var comment = {
                                    "comment_id":data.id,
                                    "user_id":this.user.user_id,
                                    "level":(data.level+1), 
                                    "name":this.user.name,
                                    "body":data.reply,
                                }
                        
                    axios.post('api/postComment',comment)
                    .then(response=>{
                        this.getComments();
                    });
                }
            },
            async getComments(){
                    axios.get('api/getComment')
                    .then(response=>{
                        this.comments = response.data
                        this.comments.map(reply=>{
                            reply.reply="";
                            reply.showReply = false;
                            reply.replies.map(reply2=>{
                                reply2.reply="";
                                reply2.showReply = false;
                            });
                        });

                    })
            },
            postComment(event){
                if(event.keyCode==13){
                    var comment = {
                                "comment_id":0,
                                "user_id":this.user.user_id,
                                "level":1, 
                                "name":this.user.name,
                                "body":this.commentBody,
                                }
                    
                    axios.post('api/postComment',comment)
                    .then(response=>{
                        this.commentBody="";
                        this.getComments();
                    })
                }
            
            }
        },
        mounted() {

            this.getComments();
        }
    }
</script>
