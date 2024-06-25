<template>
  <Navbar />

  <div class="container mt-4">
    <div class="row mb-3">
      <div class="col text-start">
        <button
          type="button"
          class="btn text-16px btn-outline-primary"
          data-bs-toggle="modal"
          data-bs-target="#exampleModal"
          data-bs-whatever="@mdo"
        >
          Add Skill
        </button>
      </div>
    </div>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-5">
      <div class="col">
        <div class="card h-100">
          <img src="/src/assets/img/images.jpeg" class="card-img-top" alt="image" />
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">I'm skill</p>
            <div class="d-flex gap-1 justify-content-end">
              <a href="#" class="btn btn-outline-danger">Delete</a>
              <a
                href="#"
                data-bs-toggle="modal"
                data-bs-target="#update"
                class="btn btn-outline-primary"
                >Update</a
              >
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100">
          <img src="/src/assets/img/images.jpeg" class="card-img-top" alt="image" />
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">I'm skill</p>
            <div class="d-flex gap-1 justify-content-end">
              <a href="#" class="btn btn-outline-danger">Delete</a>
              <a
                href="#"
                data-bs-toggle="modal"
                data-bs-target="#update"
                class="btn btn-outline-primary"
                >Update</a
              >
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100">
          <img src="/src/assets/img/images.jpeg" class="card-img-top" alt="image" />
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">I'm skill</p>
            <div class="d-flex gap-1 justify-content-end">
              <a href="#" class="btn btn-outline-danger">Delete</a>
              <a
                href="#"
                data-bs-toggle="modal"
                data-bs-target="#update"
                class="btn btn-outline-primary"
                >Update</a
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="mb-3 w-100">
      <div
        class="modal fade"
        id="exampleModal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog">
          <div class="modal-content p-4">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Card</h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              <form>
                <div class="mb-3">
                  <input class="form-control" type="file" id="formFile" />
                </div>
                <div class="mb-3">
                  <input
                    type="text"
                    class="form-control"
                    id="recipient-name"
                    placeholder="Card title"
                  />
                </div>
                <div class="mb-3">
                  <label for="message-text" class="col-form-label">Description:</label>
                  <textarea
                    class="form-control"
                    id="message-text"
                    placeholder="Card description"
                  ></textarea>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Cancel
              </button>
              <button type="button" class="btn btn-outline-primary">Create</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div
    class="modal fade"
    id="update"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content p-4">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Card</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <input class="form-control" type="file" id="formFile" />
            </div>
            <div class="mb-3">
              <input
                type="text"
                class="form-control"
                id="recipient-name"
                placeholder="Card title"
              />
            </div>
            <div class="mb-3">
              <label for="message-text" class="col-form-label">Description:</label>
              <textarea
                class="form-control"
                id="message-text"
                placeholder="Card description"
              ></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Cancel
          </button>
          <button type="button" class="btn btn-primary">Create</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Navbar from "./Navbar.vue";

export default {
  components: {
    Navbar,
  },
};
</script>

<style>
.modal-content {
  width: 100%;
}

.modal-dialog {
  max-width: 800px; /* Adjust as needed */
}

.modal-header,
.modal-body,
.modal-footer {
  padding: 1rem 1.5rem;
}
</style>
