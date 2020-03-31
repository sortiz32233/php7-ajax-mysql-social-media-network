<div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="Create New Post" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background: rgba(0,0,0,.9);">
      <div class="modal-header">
        <h5 class="modal-title text-white font-weight-lighter">add comment</h5>
        <a type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </a>
      </div>
      <div class="modal-body pb-0 mb-0">
        <form action="create_comment.php" method="POST" id="comment_post_form" class="post_form">
          <div class="form-group">
            <textarea name="comment_post_content" minlength="1" id="comment_post_content" class="form-control mt-2 mb-4" style="resize:none" placeholder="enter comment" rows="2"></textarea>
          </div>
          <h6 id="comment_post_message"></h6>
      </div>
        <div class="form-group">
          <input type="hidden" name="post_id" id="post_id" value="0">

          <button type="submit" name="submit" id="postBtn" class="btn btn-outline-light text-white float-right m-3">comment</button>
        </div>
        </form>
    </div>
  </div>
</div>
