package com.example.assignment_5.ui.home;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.BitmapFactory;
import android.os.Bundle;
import android.text.method.ScrollingMovementMethod;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.core.content.ContextCompat;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.Observer;
import androidx.lifecycle.ViewModelProvider;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import com.example.assignment_5.MainActivity;
import com.example.assignment_5.R;
import com.example.assignment_5.RecyclerViewAdapter;
import com.example.assignment_5.databinding.FragmentHomeBinding;
import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import com.google.gson.annotations.SerializedName;

import org.jetbrains.annotations.NotNull;

import java.io.IOException;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;
import java.util.concurrent.TimeUnit;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.FormBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;
import okhttp3.ResponseBody;

import static android.content.ContentValues.TAG;

public class HomeFragment extends Fragment {

    private HomeViewModel homeViewModel;
    private FragmentHomeBinding binding;
    private String key;
    private ArrayList<RecyclerViewAdapter.gamecard> games = new ArrayList<>();
    private SwipeRefreshLayout swipeRefreshLayout;
    private RecyclerViewAdapter adapter;

    private void toast(CharSequence message) {
        Context context = getContext();
        getActivity().runOnUiThread(new Runnable() {
            @Override
            public void run() {
                Toast.makeText(context, message, Toast.LENGTH_SHORT).show();
            }
        });
    }

    @Override
    public void onStart() {
        super.onStart();
        SharedPreferences shared = getActivity().getSharedPreferences("user", Context.MODE_PRIVATE);
        key = shared.getString("key", "0000000000");
        adapter=null;
        loadGames(true);
        swipeRefreshLayout = getActivity().findViewById(R.id.swipeContainer);
        swipeRefreshLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                loadGames(false);
                toast("Loading New Games :)");
            }
        });

    }

    public View onCreateView(@NonNull LayoutInflater inflater,
                             ViewGroup container, Bundle savedInstanceState) {
        homeViewModel =
                new ViewModelProvider(this).get(HomeViewModel.class);

        binding = FragmentHomeBinding.inflate(inflater, container, false);
        View root = binding.getRoot();

        SharedPreferences shared = getActivity().getSharedPreferences("user", Context.MODE_PRIVATE);
        if(shared.contains("key")==false) {
            Intent switchAct = new Intent(getContext(), MainActivity.class);
            startActivity(switchAct);
        }

        homeViewModel.getText().observe(getViewLifecycleOwner(), new Observer<String>() {
            @Override
            public void onChanged(@Nullable String s) {

            }
        });



        return root;
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        binding = null;
    }

    @SerializedName("release date") public String releaseDate;
    private void loadGames(boolean def) {
        OkHttpClient client = new OkHttpClient.Builder()
                .connectTimeout(20, TimeUnit.SECONDS)
                .readTimeout(20, TimeUnit.SECONDS)
                .writeTimeout(20, TimeUnit.SECONDS)
                .callTimeout(20,TimeUnit.SECONDS)
                .build();

        String arr[] = new String[1];
        arr[0] = "title";

        SharedPreferences shared = getActivity().getSharedPreferences("user", Context.MODE_PRIVATE);

        String genres[] = new String[]{"action", "role-playing-games-rpg", "adventure",
                "shooter", "racing", "indie", "platformer", "strategy", "*"};

        String scores[] = new String[] {"60","70", "80", "90", "*"};

        String score ="*";
        if(!shared.getString("score","1").equals("4")) {
            int lower = Integer.parseInt(scores[Integer.parseInt(
                    shared.getString("score","1"))]);
            int upper = lower +10;
            score = lower+","+upper;
        }

        String GenreVal = genres[Integer.parseInt(shared.getString("genre","1"))];
        String PlatVal = api_plat_map(Integer.parseInt(shared.getString("platform","1")));

        Log.d(TAG, "loadGames: "+GenreVal);
        Log.d(TAG, "loadGames: "+PlatVal);
        Log.d(TAG, "loadGames: "+score);

        if(def) {
            GenreVal="*";
            PlatVal="*";
            score="*";
        }

        RequestBody multi = new FormBody.Builder()
                .add("type", "info")
                .add("key", key)
                .add("limit", "5")
                .add("genre", GenreVal)
                .add("platforms", PlatVal)
                .add("score", score)
                .add("return[0]", "title")
                .add("return[1]","developers")
                .add("return[2]","metacritic")
                .add("return[3]","platforms")
                .add("return[4]","artwork")
                .add("return[5]","release")
                .add("return[6]","genres")
                .add("return[7]", "description")
                .build();

        String url = "http://10.0.2.2/Assignment_5/api.php";
        Request request = new Request.Builder()
                .url(url)
                .post(multi)
                .build();

        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(@NotNull Call call, @NotNull IOException e) {
                e.printStackTrace();
            }

            @Override public void onResponse(Call call, Response response) throws IOException {
                try (ResponseBody responseBody = response.body()) {
                    if (!response.isSuccessful()) throw new IOException("Unexpected code " + response);
                    GsonBuilder build = new GsonBuilder();
                    Gson converter = build.create();

                    String json = responseBody.string();
                    //json.indexOf("platforms");
                    Log.d(TAG, "onResponse: "+json);
                    API_response resp = converter.fromJson(json, API_response.class);

                    if(resp.status=="error")
                        toast("Error receiving data");
                    //explanation is too long for a toast
                    //toast(resp.explanation)

                    Log.d("D: ", "onResponse: "+json);
                    games.clear();
                    //Log.d("Tag:: ", "onResponse: "+resp.data[0].title);
                    for(int i=0; i<resp.data.length; i++) {
                        games.add(resp.data[i]);
                        //Log.d(TAG, "onResponse: "+games.get(i).title);
                    }
                    Log.d(TAG, "onResponse: "+games.size());

                    getActivity().runOnUiThread(new Runnable() {

                        @Override
                        public void run() {

                            //while(getActivity().findViewById(R.id.recyclervieww)==null){};
                            RecyclerView recyclerView = getActivity().findViewById(R.id.recyclervieww);
                            if(adapter==null) {
                                adapter = new RecyclerViewAdapter(games, getContext());
                                recyclerView.setAdapter(adapter);
                            }
                            else {
                                RecyclerViewAdapter adapter = (RecyclerViewAdapter) recyclerView.getAdapter();
                                //adapter.clear();
                                adapter.AddAll(games);
                            }
                            recyclerView.setLayoutManager(new LinearLayoutManager(getContext()));
                            swipeRefreshLayout.setRefreshing(false);
                        }
                    });

                }
            }
        });
    }

    class platforms {
        public String platforms;
    }

    class API_response {
        public String timestamp;
        public String status;
        public RecyclerViewAdapter.gamecard data[];
        public String explanation;

    }

    private String api_plat_map(int value) {
        switch (value) {
            case 5: {
                return "playstation-4";
            }
            case 4: {
                return "playstation-3";
            }
            case 6 : {
                return "playstation-5";
            }
            case 1: {
                return "xbox-360";

            }
            case 3: {
                return "xbox-one";

            }
            case 2: {
                return "xbox-sx";

            }
            case 7: {
                return "nintendo-switch";

            }
            case 8: {
                return "pc";

            }
            default: return "*";
        }
    }
}


