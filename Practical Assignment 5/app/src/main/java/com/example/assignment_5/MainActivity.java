package com.example.assignment_5;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.os.Looper;
import android.preference.PreferenceManager;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import com.squareup.moshi.JsonAdapter;
import com.squareup.moshi.Moshi;

import org.jetbrains.annotations.NotNull;

import java.io.IOException;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.FormBody;
import okhttp3.Headers;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;
import okhttp3.ResponseBody;

public class MainActivity extends AppCompatActivity implements View.OnClickListener {

    private static final OkHttpClient client = new OkHttpClient();
    private int ToastDur = Toast.LENGTH_SHORT;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        Button login = findViewById(R.id.submitLogin);
        login.setOnClickListener(this);
    }

    @Override
    protected void onResume() {
        super.onResume();

    }

    @Override
    protected void onStart() {
        super.onStart();
        SharedPreferences shared = getSharedPreferences("user", Context.MODE_PRIVATE);
        if(!shared.getString("key", "0000000000").equals("0000000000")) {
            Intent switchAct = new Intent(getApplicationContext(), trending.class);
            startActivity(switchAct);
        }
    }

    @Override
    public void onClick(View v) {
        //toast("text");
        TextView emailfield = findViewById(R.id.EmailField);
        String email = String.valueOf(emailfield.getText());
        TextView passwordfield = findViewById(R.id.PasswordField);
        String password = String.valueOf(passwordfield.getText());

        Log.d("Text view: ", "onClick: "+email+" "+password);

        ValidateLogin(email, password);

    }

    //couldn't get the mapping to tuple library to work :(
    class API_login_validation {
        public String status;
        public String explanation;
    }

    class API_login_response {
        public String name;
        public String Key;
        public String theme;
        public String genre;
        public String platform;
        public String score;
    }

    private void ValidateLogin(String email, String password) {
        RequestBody form = new FormBody.Builder()
                .add("password", password)
                .add("email", email)
                .build();

        String url = "http://10.0.2.2/Assignment_5/PHP files/validate-login.php";
        Request request = new Request.Builder()
                .url(url)
                .post(form)
                .build();


        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(@NotNull Call call, @NotNull IOException e) {
                //toast failure
            }

            @Override
            public void onResponse(@NotNull Call call, @NotNull Response response) throws IOException {
                try (ResponseBody responseBody = response.body()) {
                    if (!response.isSuccessful()) throw new IOException("Unexpected code " + response);

                    GsonBuilder build = new GsonBuilder();
                    Gson converter = build.create();
                    API_login_validation resp = converter.fromJson(responseBody.string(), API_login_validation.class);



                    if(resp.status.equals("error")) {
                        toast(resp.explanation);
                        return;
                    }
                    else {
                        toast("logging in...");
                        SubmitLogin(email, password);
                    }
                }
            }
        });

    }

    private void toast(CharSequence message) {
        Context context = getApplicationContext();
        ContextCompat.getMainExecutor(context).execute(() -> {
            Toast.makeText(context, message, ToastDur).show();
        });
    }

    private void SubmitLogin(String email, String password) {
        OkHttpClient client = new OkHttpClient();

        RequestBody form = new FormBody.Builder()
                .add("type", "login")
                .add("key", "0000000000")
                .add("password", password)
                .add("email", email)
                .build();

        String url = "http://10.0.2.2/Assignment_5/api.php";
        Request request = new Request.Builder()
                .url(url)
                .post(form)
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
                    API_login_response resp = converter.fromJson(responseBody.string(), API_login_response.class);

                    toast("Logged in...");
                    toast("Redirecting...");

                    //store key...

                    Log.d("KEY: ", "onResponse: "+resp.Key);
                    Log.d("KEY: ", "onResponse: "+resp.name);
                    Log.d("KEY: ", "onResponse theme: "+resp.theme);
                    Log.d("KEY: ", "onResponse genre: "+resp.genre);
                    Log.d("KEY: ", "onResponse platform: "+resp.platform);
                    Log.d("KEY: ", "onResponse score: "+resp.score);

                    SharedPreferences shared = getSharedPreferences("user", Context.MODE_PRIVATE);
                    SharedPreferences.Editor ed = shared.edit();
                    ed.putString("key", resp.Key);
                    ed.putString("theme", resp.theme);
                    ed.putString("genre", resp.genre);
                    ed.putString("platform", resp.platform);
                    ed.putString("score", resp.score);
                    ed.commit();

                    String val= shared.getString("key", "empty");
                    Log.d("Key: ", "KEYYY: "+val);

                    Intent switchAct = new Intent(getApplicationContext(), trending.class);
                    startActivity(switchAct);
                }
            }
        });
    }
}

