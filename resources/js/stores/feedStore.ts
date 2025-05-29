import { router } from "@inertiajs/vue3";
import { useAxios } from "@vueuse/integrations/useAxios";
import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import { isEqualObjects } from "@/lib/utils";
import type { ITweet } from "@/types";
import { useAuthStore } from "./authStore";

export const useFeedStore = defineStore("feed", () => {
  const feed = ref([] as ITweet[]);
  /**
   * Sets the home feed with an array of tweets.
   * @param feed - An array of tweets.
   */
  function setFeed(data: ITweet[]): void {
    feed.value = data;
  }
  /**
   * Fetches the home feed from the server.
   */
  async function getFeed(): Promise<void> {
    try {
      const authStore = useAuthStore();

      const request = await axios.get(route("feed.home"), {
        params: { userId: authStore.user.id },
      });

      const response = await request.data;

      setFeed(response);
    } catch (e) {
      console.error("Error Fetching Home Feed:", e);
    }
  }
  /**
   * Adds a new tweet and refreshes the home feed.
   * @param body - The data for the new tweet.
   */
  function addNewTweet(body: string): void {
    router.post(
      route("tweet.store"),
      { body },
      {
        onSuccess: () => getFeed(),
      }
    );
  }

  /**
   * Updates a tweet in the feed.
   * @param tweet - The tweet to update.
   */
  function updateTweet(tweet: ITweet): void {
    console.log("update tweet", feed.value);
    // find the tweet in the feed
    const index = feed.value.findIndex(
      (item: { id: number }) => item.id === tweet.id
    );

    // check if tweet is not found
    if (index < 0) throw new Error("TWEET IS NOT FOUND!!!!!!!!!!!!!");

    // check if tweets are not equal then continue and update the tweet
    if (!isEqualObjects(tweet, feed.value[index])) {
      feed.value[index] = tweet;
    }
  }
  /**
   * Fetches a tweet by its ID and updates it in the feed.
   * @param id - The ID of the tweet to fetch.
   */
  async function fetchTweet(id: number): Promise<void> {
    const authStore = useAuthStore();
    const { data: tweet } = await useAxios(route("tweets.api.show", id), {
      params: { userId: authStore.user.id },
    });

    updateTweet(tweet.value);
  }
  return { feed, setFeed, getFeed, addNewTweet, updateTweet, fetchTweet };
});
