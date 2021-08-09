package com.example.assignment_5;

import android.content.Context;
import android.content.SharedPreferences;
import android.os.Bundle;

import androidx.core.content.ContextCompat;
import androidx.fragment.app.Fragment;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.Toast;

import com.google.android.material.chip.Chip;
import com.google.android.material.chip.ChipGroup;

import org.jetbrains.annotations.NotNull;

import java.io.IOException;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.FormBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

import static android.content.ContentValues.TAG;

/**
 * A simple {@link Fragment} subclass.
 * Use the {@link preferences#newInstance} factory method to
 * create an instance of this fragment.
 */
public class preferences extends Fragment {

    // TODO: Rename parameter arguments, choose names that match
    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";

    // TODO: Rename and change types of parameters
    private String mParam1;
    private String mParam2;

    public preferences() {
        // Required empty public constructor
    }

    /**
     * Use this factory method to create a new instance of
     * this fragment using the provided parameters.
     *
     * @param param1 Parameter 1.
     * @param param2 Parameter 2.
     * @return A new instance of fragment preferences.
     */
    // TODO: Rename and change types and number of parameters
    public static preferences newInstance(String param1, String param2) {
        preferences fragment = new preferences();
        Bundle args = new Bundle();
        args.putString(ARG_PARAM1, param1);
        args.putString(ARG_PARAM2, param2);
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        if (getArguments() != null) {
            mParam1 = getArguments().getString(ARG_PARAM1);
            mParam2 = getArguments().getString(ARG_PARAM2);
        }
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View rootView = inflater.inflate(R.layout.fragment_preferences, container, false);

        Button btn = (Button)rootView.findViewById(R.id.SavePrefs);
        btn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                SavePreferences();
            }
        });

        return rootView;
    }

    @Override
    public void onStart() {
        super.onStart();
        LoadPreferences();
    }

    private void LoadPreferences() {
        ChipGroup group = getActivity().findViewById(R.id.ChoosePlatforms);
        group.clearCheck();
        group = getActivity().findViewById(R.id.genres);
        group.clearCheck();
        group = getActivity().findViewById(R.id.ScoresChips);
        group.clearCheck();

        SharedPreferences shared = getActivity().getSharedPreferences("user", Context.MODE_PRIVATE);
        String genre = shared.getString("genre", "1");
        String platform = shared.getString("platform", "1");
        String score = shared.getString("score", "1");

        Log.d(TAG, "LoadPreferences: preferences...");
        setPlatform(Integer.parseInt(platform));
        setGenre(Integer.parseInt(genre));
        setScore(Integer.parseInt(score));
    }

    private void setPlatform(int key) {
        ChipGroup group = getActivity().findViewById(R.id.ChoosePlatforms);
        Chip platform =null;
        switch(key) {
            case 1: {
                platform = group.findViewWithTag("xbox-360");
                break;
            }
            case 2: {
                platform = group.findViewWithTag("xbox-sx");
                break;
            }
            case 3: {
                platform = group.findViewWithTag("xbox-one");
                break;
            }
            case 4: {
                platform = group.findViewWithTag("ps3");
                break;
            }
            case 5: {
                platform = group.findViewWithTag("ps4");
                break;
            }
            case 6: {
                platform = group.findViewWithTag("ps5");
                break;
            }
            case 7: {
                platform = group.findViewWithTag("nintendo-switch");
                break;
            }
            case 8: {
                platform = group.findViewWithTag("pc");
                break;
            }
            case 9: {
                platform = group.findViewWithTag("allPlats");
                break;
            }
        }
        platform.setChecked(true);
    }

    private void setScore(int key) {
        ChipGroup group = getActivity().findViewById(R.id.ScoresChips);
        Chip score = null;
        switch (key) {
            case 0: {
                score = group.findViewWithTag("60");
                break;
            }
            case 1: {
                score = group.findViewWithTag("70");
                break;
            }
            case 2: {
                score = group.findViewWithTag("80");
                break;
            }
            case 3: {
                score = group.findViewWithTag("90");
                break;
            }
            default: {
                score = group.findViewWithTag("allScores");
                break;
            }
        }
        score.setChecked(true);
    }

    private void setGenre(int key) {
        ChipGroup group = getActivity().findViewById(R.id.genres);
        Chip genre =null;
        switch(key) {
            case 0: {
                genre = group.findViewWithTag("action");
                break;
            }
            case 1: {
                genre = group.findViewWithTag("rpg");
                break;
            }
            case 2: {
                genre = group.findViewWithTag("adventure");
                break;
            }
            case 3: {
                genre = group.findViewWithTag("shooter");
                break;
            }
            case 4: {
                genre = group.findViewWithTag("racing");
                break;
            }
            case 5: {
                genre = group.findViewWithTag("indie");
                break;
            }
            case 6: {
                genre = group.findViewWithTag("platformer");
                break;
            }
            case 7: {
                genre = group.findViewWithTag("strategy");
                break;
            }
            default: {
                genre = group.findViewWithTag("allGenres");
                break;
            }
        }
        genre.setChecked(true);
    }

    private void SavePreferences() {
        Log.d(TAG, "SavePreferences: Saved...");
        ChipGroup genres = getActivity().findViewById(R.id.genres);
        Chip genre = getActivity().findViewById(genres.getCheckedChipId());
        String genreLine = (String) genre.getText();

        ChipGroup platforms = getActivity().findViewById(R.id.ChoosePlatforms);
        Chip platform = getActivity().findViewById(platforms.getCheckedChipId());
        String platformLine = (String) platform.getText();

        ChipGroup scores = getActivity().findViewById(R.id.ScoresChips);
        Chip score = getActivity().findViewById(scores.getCheckedChipId());
        String scoreLine = (String) score.getText();

        Log.d(TAG, "SavePreferences: " + genreLine);
        Log.d(TAG, "SavePreferences: " + MapGenre(genreLine));
        Log.d(TAG, "SavePreferences: " + platformLine);
        Log.d(TAG, "SavePreferences: " + MapPlatform(platformLine));
        Log.d(TAG, "SavePreferences: " + scoreLine);
        Log.d(TAG, "SavePreferences: " + ScoreMap(scoreLine));

        //store in shared
        SharedPreferences shared = getActivity().getSharedPreferences("user", Context.MODE_PRIVATE);
        SharedPreferences.Editor ed = shared.edit();

        ed.putString("genre", MapGenre(genreLine));
        ed.putString("platform", MapPlatform(platformLine));
        ed.putString("score", ScoreMap(scoreLine));
        ed.commit();

        toast("Preferences changed...");

        StorePrefs(MapGenre(genreLine), MapPlatform(platformLine), ScoreMap(scoreLine));
    }

    private void toast(CharSequence message) {
        Context context = getContext();
        getActivity().runOnUiThread(new Runnable() {
            @Override
            public void run() {
                Toast.makeText(context, message, Toast.LENGTH_SHORT).show();
            }
        });
    }

    private void StorePrefs(String genreLine, String platformLine, String scoreLine) {

        OkHttpClient client = new OkHttpClient();
        SharedPreferences shared = getActivity().getSharedPreferences("user", Context.MODE_PRIVATE);
        String key = shared.getString("key", "0000000000");

        RequestBody multi = new FormBody.Builder()
                .add("type", "update")
                .add("key", key)
                .add("set", "filters")
                .add("values[0]", genreLine)
                .add("values[1]", platformLine)
                .add("values[2]", scoreLine)
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

            @Override
            public void onResponse(@NotNull Call call, @NotNull Response response) throws IOException {
                Log.d(TAG, "onResponse: "+response.body().string());
                toast("Preferences saved");
            }
        });
    }

    private String MapPlatform(String plat) {
        if(plat.equals("Xbox 360")){
            return "1";
            //return "14";
        }
        if(plat.equals("Xbox SX")){
            return "2";
            //return "186";
        }
        if(plat.equals("Xbox One")){
            return "3";
            //return "1";
        }
        if(plat.equals("PS3")){
            return "4";
            //return "16";
        }
        if(plat.equals("PS4")){
            return "5";
            //return "18";
        }
        if(plat.equals("PS5")){
            return "6";
            //return "187";
        }
        if(plat.equals("Switch")){
            return "7";
            //return "7";
        }
        if(plat.equals("PC")){
            return "8";
            //return "4";
        }
        else return "9";
    }

    private String MapGenre(String genre) {
        String genres[] = new String[]{"action", "rpg", "adventure",
                "shooter", "racing", "indie", "platformer", "strategy", "all"};

        for(int i=0; i<genres.length; i++) {
            if(genre.toLowerCase().equals(genres[i]))
                return String.valueOf(i);
        }
        return "8";
    }

    private String ConvertScore(String score) {
        if(score.equals("All"))
            return "*";
        String line = score.substring(0,2);
        line += ",";
        line += score.substring(4,score.length());
        return line;
    }

    private String ScoreMap(String value) {
        String genres[] = new String[]{
                "60->70", "70->80","80->90","90->100", "All"};
        for(int i=0; i<genres.length; i++)
            if(genres[i].equals(value))
                return String.valueOf(i);
        return "4";

    }

}