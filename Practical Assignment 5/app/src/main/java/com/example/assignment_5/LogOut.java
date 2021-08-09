package com.example.assignment_5;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;

import androidx.annotation.LongDef;
import androidx.core.content.ContextCompat;
import androidx.fragment.app.Fragment;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.Toast;

import static android.content.ContentValues.TAG;

/**
 * A simple {@link Fragment} subclass.
 * Use the {@link LogOut#newInstance} factory method to
 * create an instance of this fragment.
 */
public class LogOut extends Fragment implements View.OnClickListener {

    // TODO: Rename parameter arguments, choose names that match
    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";

    // TODO: Rename and change types of parameters
    private String mParam1;
    private String mParam2;

    public LogOut() {
        // Required empty public constructor
    }

    /**
     * Use this factory method to create a new instance of
     * this fragment using the provided parameters.
     *
     * @param param1 Parameter 1.
     * @param param2 Parameter 2.
     * @return A new instance of fragment LogOut.
     */
    // TODO: Rename and change types and number of parameters
    public static LogOut newInstance(String param1, String param2) {
        LogOut fragment = new LogOut();
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
        View rootView= inflater.inflate(R.layout.fragment_log_out, container, false);

        Button btn = (Button)rootView.findViewById(R.id.logoutButton);
        btn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                LogOut();
            }
        });

        return rootView;
    }

    @Override
    public void onClick(View v) {

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
    
    private void LogOut() {
        SharedPreferences shared = getActivity().getSharedPreferences("user", Context.MODE_PRIVATE);
        SharedPreferences.Editor ed = shared.edit();
        ed.clear().commit();

        //Log.d(TAG, "LogOut: "+shared.getString("key","0000000000"));

        Intent switchAct = new Intent(getContext(), MainActivity.class);
        startActivity(switchAct);
        toast("Logged out...");
    }

    @Override
    public boolean OnQueryTextChange(String newText) {
        if(newText.length()<2) {
            return false;
        }
        String sline ="";
        for(int i=0; i<newText.length(); i++) {
            if( newText.charAt(i)!=' ') {
                sline += Character.toLowerCase(newText.charAt(i));
            }
            sline+='+';
        }

        if(getResults(sline, false)!=null) {
            return true;
        }
        else if(getResults(sline, true)!=null) {
            return true;
        }
        else return false;


    }
}