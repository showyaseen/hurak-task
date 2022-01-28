<template>
  <b-row>
    <b-card title="Hurak VueJs Task" class="m-4">
      <span v-if="showColors">{{ colors }}</span>
      <b-button
        v-if="taskOneDone"
        v-on:click.prevent="shuffle"
        class="m-2"
        variant="primary"
        >Shuffle
      </b-button>
      <b-button
        v-if="taskOneDone"
        v-on:click.prevent="sortBoxes"
        class="m-2"
        variant="primary"
        >Sort
      </b-button>

      <b-card-group class="m-4" deck>
        <box
          :key="`box-${index}`"
          v-for="(box, index) in boxes"
          :box="box"
        ></box>
      </b-card-group>
      
    </b-card>
  </b-row>
</template>

<script>
import axios from "axios";
import Box from "./Box.vue";
export default {
  components: {
    Box,
  },
  data() {
    return {
      interval: null,
      boxes: [],
      colors: ["red", "yellow", "green", "blue", "pink", "grey"],
      defaultWidth: 100,
      defaultHeight: 40,
      everyMinute: 600,
      showColors: true,
      taskOneDone: false,
    };
  },
  mounted() {
    this.addFirstBox();
    this.interval = setInterval(this.duplicateBoxes, this.everyMinute);
  },
  methods: {
    addFirstBox() {
      let box = {
        color: this.getRandomColor(),
        height: this.defaultHeight,
        width: this.defaultWidth,
      };
      this.boxes.push(box);
      this.storeBoxes([box]);
    },
    duplicateBoxes() {
      if (this.boxes.length < 16) {
        let newBoxes = [];
        for (let i = 0; i < this.boxes.length; i++) {
          newBoxes.push({
            color: this.getRandomColor(),
            height: this.defaultHeight,
            width: this.defaultWidth,
          });
        }
        this.addBoxes(newBoxes);
        this.storeBoxes(newBoxes);
      } else {
        clearInterval(this.interval);
        this.sendEmail();
        this.taskOneDone = true;
      }
    },
    addBoxes(boxes) {
      for (let box of boxes) {
        this.boxes.push(box);
      }
    },
    getRandomColor() {
      return this.colors[Math.floor(Math.random() * this.colors.length)];
    },
    storeBoxes(boxes) {
      axios
        .post("/api/boxes", { boxes: boxes })
        .then((response) => {
          console.log("we have stored boxes", response.data);
        })
        .catch((err) => {
          clearInterval(this.interval);
          console.log("some thing wrong happened");
        });
    },
    sendEmail() {
      axios
        .post("/api/send-email")
        .then((response) => {
          console.log("send task finish email", response.data);
        })
        .catch((err) => {
          console.log("some thing wrong happened");
        });
    },
    shuffle() {
      let currentIndex = this.colors.length;
      let randomIndex;
      while (currentIndex != 0) {
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex--;
        [this.colors[currentIndex], this.colors[randomIndex]] = [
          this.colors[randomIndex],
          this.colors[currentIndex],
        ];
      }
      this.showColors = false;
      this.showColors = true;
    },
    sortBoxes() {
      this.boxes.sort(
        (box1, box2) =>
          this.colors.indexOf(box1.color) - this.colors.indexOf(box2.color)
      );
    },
  },
};
</script>

