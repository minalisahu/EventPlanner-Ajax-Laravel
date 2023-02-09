<template>
  <div class="form-group row">
    <label
      for="role_id"
      :class="
        error
          ? 'col-4 control-label has-error ' + labelclass
          : 'col-4 control-label ' + labelclass
      "
      >{{ label }}</label
    >
    <div class="col-8">
      <select
        class="form-control simple-select"
        :name="name"
        :id="name"
        :disabled="isdisabled == 'true' ? true : false"
      >
        <option selected disabled>Select here...</option>
        <option
          v-for="pair in data"
          :value="pair.id"
          v-bind:key="pair.id"
          :selected="value == pair.id"
        >
          {{ pair.name }}
        </option>
      </select>
      <p class="help-block" v-if="error">{{ error }}</p>
    </div>
  </div>
</template>
<script>
export default {
  props: [
    "label",
    "name",
    "data",
    "value",
    "error",
    "labelclass",
    "isdisabled",
  ],
};
</script>
