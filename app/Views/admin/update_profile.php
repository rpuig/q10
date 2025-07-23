<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Create Page</h3>
                    </div>
                    <div class="card-body">
                        
                        <?php echo form_open_multipart('users/profile_update/' . $sessionData['Userid']); ?>

                        <div class="form-group mb-3 ">
                            <label class="form-label">Name</label>
                            <div>
                                <input type="text" class="form-control" name="name" value="<?= $sessionData['name'] ?>">
                            </div>
                        </div>

                        <div class="form-group mb-3 ">
                            <label class="form-label">Profile Picture</label>
                            <div>
                                <input type="file" class="form-control" accept="image/png, image/jpeg" name="post_image" id="user_profile_pic" placeholder="Upload image">
                            </div>
                            <?php if ($profile['user_profile_pic']) {
                                echo '<img src="' . base_url('assets/uploads/user_profile_images/' . $profile['user_profile_pic']) . '" width="75px" class="pt-3">';
                            } ?>
                        </div>

                     

                     
                        <div class="form-group mb-3 ">
                            <label class="form-label">About me</label>
                            <textarea id="summernote" name="body"><?= esc($page['body'])  ?></textarea>
                        </div>

                       

                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>