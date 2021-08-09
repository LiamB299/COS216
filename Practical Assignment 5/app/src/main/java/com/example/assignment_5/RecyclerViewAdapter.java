package com.example.assignment_5;

import android.content.Context;
import android.graphics.BitmapFactory;
import android.text.method.ScrollingMovementMethod;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.recyclerview.widget.RecyclerView;

import org.jetbrains.annotations.NotNull;

import java.io.IOException;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;

public class RecyclerViewAdapter extends RecyclerView.Adapter<RecyclerViewAdapter.ViewHolder> {
    private static final String TAG = "ReyclerViewAdapter";

    private ArrayList<gamecard> games = new ArrayList<>();
    private Context context;

    public RecyclerViewAdapter(ArrayList<gamecard> games, Context context) {
        this.games = games;
        this.context = context;
    }

    public void clear() {
        games.clear();
        //notifyDataSetChanged();
        notifyItemRangeChanged(0, games.size());
    }

    public void AddAll(ArrayList<gamecard> NewGames) {
        //if(games.size()!=0) {
        //    games.clear();
        //}
        for(int i=0; i<0; i++) {
            games.add(NewGames.get(i));
        }
        notifyDataSetChanged();
    }

    @NonNull
    @NotNull
    @Override
    public RecyclerViewAdapter.ViewHolder onCreateViewHolder(@NonNull @NotNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.recycler_game_card, parent, false);
        ViewHolder holder = new ViewHolder(view);
        return holder;
    }

    @Override
    public void onBindViewHolder(@NonNull @NotNull RecyclerViewAdapter.ViewHolder holder, int position) {
        Log.d(TAG, "onBindViewHolder: generating...");
        if(games.get(position)==null) {
            return;
        }
        /******************************/
        URL url = null;
        try {
            url = new URL(games.get(position).artwork);
        } catch (MalformedURLException e) {
            e.printStackTrace();
        }
        try {
            holder.gameArt.setImageBitmap(BitmapFactory.
                    decodeStream(url.openConnection().
                            getInputStream()));
        } catch (IOException e) {
            e.printStackTrace();
        }
        /*********************************/
        holder.gameTitle.setText(games.get(position).title);
        holder.gameScore.setText(games.get(position).metacritic);
        holder.gameDev.setText(deSerial(games.get(position).developers));
        holder.gameRel.setText(games.get(position).release_date);
        holder.gamePlat.setText(deSerial(games.get(position).genres));
        holder.gameGen.setText(games.get(position).description);

        holder.gameGen.setMovementMethod(new ScrollingMovementMethod());

    }

    @Override
    public int getItemCount() {
        return games.size();
    }

    //holds in memory all generated views (cards)
    public class ViewHolder extends RecyclerView.ViewHolder {

        ImageView gameArt;
        TextView gameTitle;
        TextView gameScore;
        TextView gameDev;
        TextView gamePlat;
        TextView gameRel;
        TextView gameGen;
        ConstraintLayout gameCard;
        public ViewHolder(@NonNull @NotNull View itemView) {
            super(itemView);
            gameArt = itemView.findViewById(R.id.gameArt);
            gameTitle = itemView.findViewById(R.id.gameTitle);
            gameScore = itemView.findViewById(R.id.gameScore);
            gameDev = itemView.findViewById(R.id.gamePlat);
            gamePlat = itemView.findViewById(R.id.gameDev);
            gameRel = itemView.findViewById(R.id.gameRel);
            gameGen= itemView.findViewById(R.id.gameGen);
        }
    }

    public class gamecard {
        public String title;
        @Nullable public String developers[];
        public String metacritic;
        public String genres[];
        //public String platforms[];
        //public platforms platforms;
        public String artwork;
        public String release_date;
        public String description;
    }

    private String deSerial(String[] arr) {
        String sline ="";
        if(arr==null)
            return sline;
        else {
            for (int i=0; i<arr.length-1; i++) {
                sline = sline+ arr[i]+", ";
            }
            sline += arr[arr.length-1];
        }
        return sline;
    }
}
